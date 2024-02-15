<?php

namespace App\Http\Controllers;

use App\Models\Applicable;
use App\Models\Dosage;
use App\Models\Drug;
use App\Models\Generic;
use App\Models\Pharmaceutical;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class DrugController extends Controller
{
    public function index(): View
    {
        $client = new Client();
        $response = $client->request('GET', 'http://127.0.0.1:8000/api/drugs');
        $drugs = json_decode($response->getBody()->getContents(), true)['data'];

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

    public function store(Request $request)
    {
        $drug = new Drug;
        $drug->name = $request->name;
        $drug->strength = $request->strength;
        $drug->dosage_form = $request->dosage_form;
        $drug->generic = $request->generic;
        $drug->company = $request->company;
        $drug->applicable_for = $request->applicable_for;

        $drug->save();

        return redirect('/drugs');
    }


}
