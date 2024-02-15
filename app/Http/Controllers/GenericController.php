<?php

namespace App\Http\Controllers;

use App\Models\Generic;
use Illuminate\Http\Request;

class GenericController extends Controller
{
    public function index(){
        $generics  = Generic::all();

        return view('generics',['generics'=>$generics]);
    }

}
