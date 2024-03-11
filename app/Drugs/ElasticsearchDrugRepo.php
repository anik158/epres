<?php

namespace App\Drugs;

use App\Models\Drug;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class ElasticsearchDrugRepo implements DrugRepository
{

    /** @var
     * \Elasticsearch\Client
     * */
    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(string $query): LengthAwarePaginator
    {
        $items = $this->searchOnElasticsearch($query);

        $drugs = collect($this->buildCollection($items));

        // Define the page size
        $pageSize = 20;

        // Get the current page number or default to 1
        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $drugs->slice(($page - 1) * $pageSize, $pageSize)->values();

        // Create our paginator and pass it to the view
        return new LengthAwarePaginator($currentPageItems, count($drugs), $pageSize, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    private function searchOnElasticsearch(string $query = ''): array
    {
        $model = new Drug;

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['name^5', 'generic'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }


    private function buildCollection(array $items): array
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Drug::query()->findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });

    }
}
