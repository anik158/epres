<?php

namespace App\Http\Controllers;

use App\Models\Applicable;
use App\Models\Generic;
use Elastic\Elasticsearch\ClientBuilder;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class GenericController extends Controller
{
    public function index():view{

//        $search = $request->input('search');
//        if ($search) {
//            $generics = Generic::where('name', 'LIKE', "%{$search}%")
//                ->orWhere('composition', 'LIKE', "%{$search}%")
//                ->orWhere('indication', 'LIKE', "%{$search}%")
//                ->get();
//        } else {
//            $generics = Generic::all();
//        }
//
        $generics = Generic::latest()->paginate(40);


        return view('generics',['generics'=>$generics]);
    }

    public function create():View{

        $applicable = Applicable::all();
        return view('create_generic',['applicable'=>$applicable]);
    }


//    public function store(Request $request): RedirectResponse
//    {
//        $request->validate([
//            'name' => 'required',
//            'composition' => 'required',
//            'indication' => 'required',
//            'therapeutic_class' => 'required',
//            'pharmacology' => 'required',
//            'dosage' => 'required',
//            'administration' => 'required',
//            'interaction' => 'required',
//            'contraindications' => 'required',
//            'side_effects' => 'required',
//            'pregnancy_lactation' => 'required',
//            'precautions' => 'required',
//            'pediatric_use' => 'required',
//            'overdose_effects' => 'required',
//            'reconstitution' => 'required',
//            'storage_condition' => 'required',
//            'applicable_for' => 'required',
//        ]);
//
//        Generic::create([
//            'name' => $request->name,
//            'composition' => $request->composition,
//            'indications' => $request->indication,
//            'therapeutic_class' => $request->therapeutic_class,
//            'pharmacology' => $request->pharmacology,
//            'dosage' => $request->dosage,
//            'administration' => $request->administration,
//            'interaction' => $request->interaction,
//            'contraindications' => $request->contraindications,
//            'side_effects' => $request->side_effects,
//            'pregnancy_lactation' => $request->pregnancy_lactation,
//            'precautions' => $request->precautions,
//            'pediatric_use' => $request->pediatric_use,
//            'overdose_effects' => $request->overdose_effects,
//            'reconstitution' => $request->reconstitution,
//            'storage_condition' => $request->storage_condition,
//            'applicable_for' => $request->applicable_for,
//        ]);
//        return redirect()->route('generic-list');
//    }

    public function store(Request $request): RedirectResponse
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'composition' => 'nullable|string',
            'indications' => 'nullable|string',
            'therapeutic_class' => 'nullable|string',
            'pharmacology' => 'nullable|string',
            'dosage' => 'nullable|string',
            'administration' => 'nullable|string',
            'interaction' => 'nullable|string',
            'contraindications' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'pregnancy_lactation' => 'nullable|string',
            'precautions' => 'nullable|string',
            'pediatric_use' => 'nullable|string',
            'overdose_effects' => 'nullable|string',
            'reconstitution' => 'nullable|string',
            'storage_condition' => 'nullable|string',
            'applicable_for' => 'nullable|string',
        ];

        $this->validate($request, $validationRules);

        $data = $request->except(['_token']);

        $generic = Generic::create($data);

        return redirect()->route('generic-list')->with('success', 'Generic drug created successfully!');
    }


    public function edit($id){
        $generic = Generic::find($id);
        $applicable = Applicable::all();

        return view('update_generic',['generic'=>$generic,'applicable'=>$applicable]);
    }

    public function update(Request $req, $id)
    {
        $generic = Generic::find($id);

        $req->validate([
            'name' => 'required',
            'composition' => 'required',
            'indication' => 'required',
            'applicable_for' => 'required'
        ]);

        try {
            $generic->update($req->all());
            return redirect()->route('generic-list');
        } catch (\Exception $e) {
            flash('An error occurred while updating the dosage.')->error();
        }

        return redirect()->route('generic-list');
    }

    public function destroy($id){
        try{
            $generic = Generic::find($id);
            $generic->delete();

            flash('Generic deleted successfully');
            return redirect()->route('generic-list');
        }catch(\Exception $e){
            flash('An error occurred while deleting the dosage.')->error();
            return redirect()->route('generic-list');
        }
    }

    //Normal Search
    public function searchGenerics(Request $request)
    {
        $searchTerm = $request->input('search');

        $start = microtime(true); // Start the timer

        $generics = Generic::where('name', 'like', '%' . $searchTerm . '%')->paginate(40);

        $time = microtime(true) - $start;

        return view('generics', ['generics' => $generics, 'time' => $time]);
    }


    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createIndexAndAddDataGeneric()
    {
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $params = ['index' => 'generics'];

        // Check if the index exists
        if ($client->indices()->exists($params)) {
            // Delete the index if it exists
            $client->indices()->delete($params);
        }

        // Create the index
        $response = $client->indices()->create($params);

        $generics = Generic::all();
        $chunks = $generics->chunk(500); // Chunk the data into groups of 500

        foreach ($chunks as $chunk) {
            $bulkParams = ['body' => []];

            foreach ($chunk as $generic) {
                $bulkParams['body'][] = [
                    'index' => [
                        '_index' => 'generics',
                        '_id'    => $generic->id,
                    ]
                ];

                $bulkParams['body'][] = $generic->toArray();
            }

            // Bulk index all drugs in this chunk
            $response = $client->bulk($bulkParams);
            echo "Done populating";
        }
    }

    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function searchgen(Request $request)
    {
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $params = [
            'index' => 'generics',
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

        $generics = collect($results['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });

        $perPage = 40;
        $page = $request->get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        $generics = new LengthAwarePaginator(
            $generics->slice($offset, $perPage)->values(), // Only grab the items we need
            $generics->count(), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // Page name
        );

        $time = microtime(true) - $start; // Calculate the time difference

        return view('generics', ['generics' => $generics, 'time' => $time]);
    }


}
