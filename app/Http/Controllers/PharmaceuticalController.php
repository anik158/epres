<?php

namespace App\Http\Controllers;

use App\Models\Pharmaceutical;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PharmaceuticalController extends Controller
{


    public function index(){
        $pharmaceuticals = Pharmaceutical::latest()->paginate(5);

        return view('companies',['pharmaceuticals'=>$pharmaceuticals]);
    }


    public function create()
    {
        return view('create_companies');
    }

    public function store(Request $request):RedirectResponse
    {
        $request->validate(
            [
                'name'=>'required'
            ]
        );

        Pharmaceutical::create([
            'name'=>$request->name
        ]);
        return redirect('companies')->with('Company added successfully');
    }
    public function edit($id)
    {
        $company = Pharmaceutical::find($id);
        return view('update_company', ['company' => $company]);
    }

    public function update(Request $req, $id){

        $req->validate([
            'name' => 'required',
        ]);

        try{

            $company = Pharmaceutical::find($id);
            $company->name = $req->name;

            $company->save();
            return redirect('/companies')->with('Company update successful');
        }catch (\Exception $e) {
            flash('An error occurred while updating the dosage.')->error();
        }

        return redirect('/companies');
    }

    public function destroy($id){

        try{
            $company = Pharmaceutical::find($id);
            $company->delete();

            return redirect('/companies')->with('Company deleted successfully');
        }catch(\Exception $e){
            flash('An error occurred while deleting the dosage.')->error();
            return redirect('/companies');
        }
    }

    //Eloquent Search
    public function searchCompanies(Request $request)
    {
        $searchTerm = $request->input('search');

        $start = microtime(true); // Start the timer

        $companies = Pharmaceutical::where('name', 'like', '%' . $searchTerm . '%')->paginate(5);

        $time = microtime(true) - $start;

        return view('companies', ['pharmaceuticals' => $companies, 'time' => $time]);
    }

    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createIndexAndAddCompanies()
    {
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $params = ['index' => 'pharmaceuticals'];

        // Check if the index exists
         if ($client->indices()->exists($params)) {
        // Delete the index if it exists
            $client->indices()->delete($params);
       }

        // Create the index
        $response = $client->indices()->create($params);

        $companies = Pharmaceutical::all();
        $chunks = $companies->chunk(500); // Chunk the data into groups of 500

        foreach ($chunks as $chunk) {
            $bulkParams = ['body' => []];

            foreach ($chunk as $company) {
                $bulkParams['body'][] = [
                    'index' => [
                        '_index' => 'pharmaceuticals',
                        '_id'    => $company->id,
                    ]
                ];

                $bulkParams['body'][] = $company->toArray();
            }

            // Bulk index all drugs in this chunk
            $response = $client->bulk($bulkParams);
            echo "Done populating";
        }
    }


    /**
     * @throws AuthenticationException
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function searchcom(Request $request)
    {
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $params = [
            'index' => 'pharmaceuticals',
            'body'  => [
                'size' => 10000,
                'query' => [
                    'multi_match' => [
                        'query' => $request->input('search'),
                        'fields' => ['name']
                    ]
                ]
            ]
        ];

        $start = microtime(true); // Start the timer

        $results = $client->search($params);

        $companies = collect($results['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });

        $perPage = 5;
        $page = $request->get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        $companies = new LengthAwarePaginator(
            $companies->slice($offset, $perPage)->values(), // Only grab the items we need
            $companies->count(), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // Page name
        );

        $time = microtime(true) - $start; // Calculate the time difference

        return view('companies', ['pharmaceuticals' => $companies, 'time' => $time]);
    }



}
