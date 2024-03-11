<?php

namespace App\Providers;

use App\Drugs\DrugRepository;
use App\Drugs\ElasticsearchDrugRepo;
use App\Drugs\EloquentSearchDrugsRepoEloDrug;
use App\Drugs\SearchEloDrugRepository;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(DrugRepository::class, function ($app) {
            if (app()->environment('local') && config('services.elasticsearch.enabled')) {
                return new ElasticsearchDrugRepo(app(Client::class));
            }

            return new EloquentSearchDrugsRepoEloDrug();
        });

        $this->app->bind(SearchEloDrugRepository::class, EloquentSearchDrugsRepoEloDrug::class);
    }



    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
