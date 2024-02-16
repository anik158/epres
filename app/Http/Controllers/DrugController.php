<?php

namespace App\Http\Controllers;

use App\Models\Applicable;
use App\Models\Dosage;
use App\Models\Drug;
use App\Models\Generic;
use App\Models\Pharmaceutical;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


class DrugController extends Controller
{
    public function index(Request $request): View
    {

        $search = $request->input('search');
        if ($search) {
            $drugs = Drug::where('name', 'LIKE', "%{$search}%")
                ->orWhere('generic', 'LIKE', "%{$search}%")
                ->orWhere('strength', 'LIKE', "%{$search}%")
                ->get();
        } else {
            $drugs = Drug::all();
        }
        //$drugs = Http::get('http://127.0.0.1:8000/api/drugs/');
        //dd($drugs);

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
