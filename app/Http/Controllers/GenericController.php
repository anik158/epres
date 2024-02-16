<?php

namespace App\Http\Controllers;

use App\Models\Applicable;
use App\Models\Generic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GenericController extends Controller
{
    public function index(Request $request){

        $search = $request->input('search');
        if ($search) {
            $generics = Generic::where('name', 'LIKE', "%{$search}%")
                ->orWhere('composition', 'LIKE', "%{$search}%")
                ->orWhere('indication', 'LIKE', "%{$search}%")
                ->get();
        } else {
            $generics = Generic::all();
        }


        return view('generics',['generics'=>$generics]);
    }

    public function create():View{

        $applicable = Applicable::all();
        return view('create_generic',['applicable'=>$applicable]);
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'composition' => 'required',
            'indication' => 'required',
            'applicable_for' => 'required',
        ]);

        Generic::create([
            'name' => $request->name,
            'composition' => $request->composition,
            'indication' => $request->indication,
            'applicable_for' => $request->applicable_for,
        ]);
        return redirect()->route('generic-list');
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

}
