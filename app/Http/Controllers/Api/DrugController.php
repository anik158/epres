<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Applicable;
use App\Models\Dosage;
use App\Models\Drug;
use App\Models\Generic;
use App\Models\Pharmaceutical;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function index(): array
    {
        return [
            'data' => Drug::query()->get(['id', 'name','strength','dosage_form','generic','company','applicable_for'])
        ];
    }

    public function store(Request $request): array
    {
        $request->validate([
            'name' => 'required',
            'strength' => 'required',
            'dosage_form' => 'required',
            'generic' => 'required',
            'company' => 'required',
            'applicable_for' => 'required',
        ]);

        $drug = Drug::create([
            'name' => $request->name,
            'strength' => $request->strength,
            'dosage_form' => $request->dosage_form,
            'generic' => $request->generic,
            'company' => $request->company,
            'applicable_for' => $request->applicable_for,
        ]);
        return [
            'message' => 'Success',
            'data' => [
                'id' => $drug->id,
                'name' => $drug->name,
            ]
        ];
    }
}
