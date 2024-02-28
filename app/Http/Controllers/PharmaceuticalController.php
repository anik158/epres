<?php

namespace App\Http\Controllers;

use App\Models\Pharmaceutical;
use Illuminate\Http\Request;

class PharmaceuticalController extends Controller
{


    public function index(){
        $pharmaceuticals = Pharmaceutical::all();

        return view('companies',['pharmaceuticals'=>$pharmaceuticals]);
    }

}
