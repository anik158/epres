<?php

namespace App\Http\Controllers;

use App\Models\Applicable;
use App\Models\Dosage;
use App\Models\Drug;
use App\Models\Generic;
use App\Models\Pharmaceutical;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DrugController extends Controller
{
    public function index(): View
    {

            $drugs = Drug::latest()->paginate(40);


        return view('drugs', ['drugs' => $drugs]);
    }

    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    // This function should be called once to create the index and populate it with data
    public function createIndexAndAddData()
    {
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $params = ['index' => 'drugs'];

        // Check if the index exists
        if ($client->indices()->exists($params)) {
            // Delete the index if it exists
            $client->indices()->delete($params);
        }

        // Create the index
        $response = $client->indices()->create($params);

        $drugs = Drug::all();
        $chunks = $drugs->chunk(500); // Chunk the data into groups of 500

        foreach ($chunks as $chunk) {
            $bulkParams = ['body' => []];

            foreach ($chunk as $drug) {
                $bulkParams['body'][] = [
                    'index' => [
                        '_index' => 'drugs',
                        '_id'    => $drug->id,
                    ]
                ];

                $bulkParams['body'][] = $drug->toArray();
            }

            // Bulk index all drugs in this chunk
            $response = $client->bulk($bulkParams);
        }
    }

// This function should be called to perform a search

    /**
     * @throws AuthenticationException
     * @throws ServerResponseException
     * @throws ClientResponseException
     */

    public function search(Request $request)
    {
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $params = [
            'index' => 'drugs',
            'body'  => [
                'size' => 10000, // Set the number of results to return
                'query' => [
                    'multi_match' => [
                        'query' => $request->input('search'),
                        'fields' => ['name', 'strength', 'dosage_form', 'generic', 'company', 'applicable_for']
                    ]
                ]
            ]
        ];

        $results = $client->search($params);

        $drugs = collect($results['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });

        $perPage = 40;
        $page = $request->get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        $drugs = new LengthAwarePaginator(
            $drugs->slice($offset, $perPage)->values(), // Only grab the items we need
            $drugs->count(), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // Page name
        );

        return view('drugs', ['drugs' => $drugs]);
    }




    public function create(): View
    {
        $dosages = Dosage::all();
        $generics = Generic::all();
        $companies = Pharmaceutical::all();
        $applicables = Applicable::all();

        return view('create_drug', compact('dosages', 'generics', 'companies', 'applicables'));
    }

    public function store(Request $request): RedirectResponse
    {
        $drug = new Drug;
        $drug->name = $request->name;
        $drug->strength = $request->strength;
        $drug->dosage_form = $request->dosage_form;
        $drug->generic = $request->generic;
        $drug->company = $request->company;
        $drug->applicable_for = $request->applicable_for;

        $drug->save();

        // After saving the new drug to the database, also add it to the Elasticsearch index
        /**
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $params = [
            'index' => 'drugs',
            'id'    => $drug->id,
            'body'  => $drug
        ];

        $response = $client->index($params);
        */
        return redirect('/drugs');
    }

    public function edit($id):View{
        $drug = Drug::find($id);

        $dosages = Dosage::all();
        $generics = Generic::all();
        $companies = Pharmaceutical::all();
        $applicables = Applicable::all();
        return view('update_drug',
            [
                'drug'=>$drug,
                'dosages'=>$dosages,
                'generics'=>$generics,
                'companies'=>$companies,
                'applicables'=>$applicables
            ]);
    }

    public function update(Request $req, $id): RedirectResponse{

        $req->validate(
            [
                'name' => 'required',
                'strength' => 'required',
                'dosage_form' => 'required',
                'generic' => 'required',
                'company' => 'required',
                'applicable_for' => 'required'
            ]
        );

        try{
            $drug = Drug::find($id);

            $drug->update($req->all());

            return redirect()->route('drug-list');
        }catch (\Exception $e){
            flash('An error occurred while updating the dosage.')->error();
            return redirect()->route('drug-list');
        }

    }



    public function destroy($id){
        try{
            $drug = Drug::find($id);
            $drug->delete();

            flash('Generic deleted successfully');
            return redirect()->route('drug-list');
        }catch(\Exception $e){
            flash('An error occurred while deleting the dosage.')->error();
            return redirect()->route('drug-list');
        }
    }



}
