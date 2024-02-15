<?php

namespace App\Http\Controllers;

use App\Models\Applicable;
use App\Models\Dosage;
use App\Models\Drug;
use App\Models\Generic;
use App\Models\Pharmaceutical;
use Illuminate\Http\Request;

class DrugController extends Controller
{

//    public function index()
//    {
//        $drugs = Drug::all();
//        return view('drugs',['drugs'=>$drugs]);
//    }

    public function index()
    {
        $drugs = Drug::all();
        return view('drugs',['drugs'=>$drugs]);
    }


    public function indexAPI(){
        return [
            'data' => Drug::query()->get(['id', 'name'])
        ];
    }

    public function create()
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
        //$drug->foreignId('dosage_form')->constrained('dosages');

        $drug->generic = $request->generic;
        //$drug->foreignId('generic')->constrained('dosages');
        $drug->company = $request->company;
        $drug->applicable_for = $request->applicable_for;

        $drug->save();

        return redirect('/drugs');
    }


}
