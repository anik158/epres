<?php

namespace App\Http\Controllers;

use App\Models\Dosage;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
//use Intervention\Image\Facades\Image;
use Illuminate\Pagination\LengthAwarePaginator;
use Laracasts\Flash\Flash;

class DosageController extends Controller
{
    public function index():view
    {

            $dosages = Dosage::latest()->paginate(5);

        return view('dosages', ['dosages' => $dosages]);
    }

    public function create():View
    {

        return view('create_dosage');
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'short_name' => 'required',
            'base_name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5048' // Max 5MB for image
        ]);

        try {
            $dosage = new Dosage;
            $dosage->name = $req->name;
            $dosage->short_name = $req->short_name;
            $dosage->base_name = $req->base_name;

            if($req->hasFile('image')) {
                $path = $req->file('image')->store('public/uploads/dosages');
                $dosage->image = basename($path);
            } else {
                $dosage->image = '';
            }

            $dosage->save();

            return redirect('/dosages');
        } catch (\Exception $e) {
            return redirect('/dosages')->withErrors('An error occurred while creating the dosage.');
        }
    }




    //Normal Search
    public function searchDosages(Request $request)
    {
        $searchTerm = $request->input('search');

        $start = microtime(true); // Start the timer

        $dosages = Dosage::where('name', 'like', '%' . $searchTerm . '%')->paginate(5);

        $time = microtime(true) - $start;

        return view('dosages', ['dosages' => $dosages, 'time' => $time]);
    }

    //populate elastic function

    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createIndexAndAddDataDosage()
    {
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $params = ['index' => 'dosages'];

        // Check if the index exists
        if ($client->indices()->exists($params)) {
            // Delete the index if it exists
            $client->indices()->delete($params);
        }

        // Create the index
        $response = $client->indices()->create($params);

        $dosages = Dosage::all();
        $chunks = $dosages->chunk(500); // Chunk the data into groups of 500

        foreach ($chunks as $chunk) {
            $bulkParams = ['body' => []];

            foreach ($chunk as $dosage) {
                $bulkParams['body'][] = [
                    'index' => [
                        '_index' => 'dosages',
                        '_id'    => $dosage->id,
                    ]
                ];

                $bulkParams['body'][] = $dosage->toArray();
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
    public function searchdos(Request $request)
    {
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $params = [
            'index' => 'dosages',
            'body'  => [
                'size' => 10000,
                'query' => [
                    'multi_match' => [
                        'query' => $request->input('search'),
                        'fields' => ['base_name']
                    ]
                ]
            ]
        ];

        $start = microtime(true); // Start the timer

        $results = $client->search($params);

        $dosages = collect($results['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });

        $perPage = 5;
        $page = $request->get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        $dosages = new LengthAwarePaginator(
            $dosages->slice($offset, $perPage)->values(), // Only grab the items we need
            $dosages->count(), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // Page name
        );

        $time = microtime(true) - $start; // Calculate the time difference

        return view('dosages', ['dosages' => $dosages, 'time' => $time]);
    }



    public function destroy($id){

        try{
            $dosage = Dosage::find($id);
            $dosage->delete();

            flash('Dosage deleted successfully');
            return redirect('/dosages');
        }catch(\Exception $e){
                flash('An error occurred while deleting the dosage.')->error();
                return redirect('/dosages');
        }
    }

    public function update(Request $req, $id){

        $req->validate([
            'name' => 'required',
            'short_name' => 'required'
        ]);

        try{

            $dosage = Dosage::find($id);
            $dosage->name = $req->name;
            $dosage->short_name = $req->short_name;

            $dosage->save();
            flash('Dosage update successful');
            return redirect('/dosages');
        }catch (\Exception $e) {
            flash('An error occurred while updating the dosage.')->error();
        }

        return redirect('/dosages');
    }

    public function edit($id)
    {
        $dosage = Dosage::find($id);
        return view('update_dosage', ['dosage' => $dosage]);
    }

}
