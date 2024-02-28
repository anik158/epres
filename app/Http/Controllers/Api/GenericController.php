<?php

namespace App\Http\Controllers\Api;

use App\Models\Applicable;
use App\Models\Generic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
class GenericController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $generics = Generic::where('name', 'LIKE', "%{$search}%")
                ->orWhere('composition', 'LIKE', "%{$search}%")
                ->orWhere('indication', 'LIKE', "%{$search}%")
                ->get();
        } else {
            $generics = Generic::all();
        }

        return response()->json(['generics' => $generics], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'composition' => 'required',
            'indication' => 'required',
            'applicable_for' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $generic = Generic::create([
            'name' => $request->name,
            'composition' => $request->composition,
            'indication' => $request->indication,
            'applicable_for' => $request->applicable_for,
        ]);

        return response()->json(['generic' => $generic], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'composition' => 'required',
            'indication' => 'required',
            'applicable_for' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $generic = Generic::find($id);
        $generic->update($request->all());

        return response()->json(['generic' => $generic], 200);
    }

    public function destroy($id)
    {
        $generic = Generic::find($id);
        $generic->delete();

        return response()->json(['message' => 'Generic deleted successfully'], 200);
    }
}
