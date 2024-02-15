<?php

namespace App\Http\Controllers;

use App\Models\Dosage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Flash;

class DosageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $dosages = Dosage::where('name', 'LIKE', "%{$search}%")
                ->orWhere('short_name', 'LIKE', "%{$search}%")
                ->get();
        } else {
            $dosages = Dosage::all();
        }

        return view('dosages', ['dosages' => $dosages]);
    }

    public function create():View
    {

        return view('create_dosage');
    }

    public function store(Request $req)
    {


        try {
            $dosage = new Dosage;
            $dosage->name = $req->name;
            $dosage->short_name = $req->short_name;

            $dosage->save();

            flash('Dosage created successfully')->success();

            return redirect('/dosages');
        } catch (\Exception $e) {
            return redirect('/dosages')->withErrors('An error occurred while creating the dosage.');
        }
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
