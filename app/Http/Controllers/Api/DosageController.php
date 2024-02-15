<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Dosage;
use App\Models\Applicable;
use App\Models\Drug;
use App\Models\Generic;
use App\Models\Pharmaceutical;
use Illuminate\Http\Request;

class DosageController extends Controller{

    public function index(): array{

        return [
            'dosages' => Dosage::query()->get(['name','short_name'])
        ];
    }

    public function store(Request $request):array{

        $request->validate(
            [
                'name' => 'required',
                'short_name' => 'required'
            ]
        );

        $dosage = Dosage::create(
            [
                'name' => $request->name,
                'short_name' => $request->short_name
            ]
        );

        return [
            'message' =>'Successful',
            'data' => [
                'id' => $dosage->id,
                'name' => $dosage->name
            ]
        ];

    }


    public function search($search): array{
        $dosages = Dosage::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('short_name', 'LIKE', "%{$search}%")
            ->get(['name', 'short_name']);

        return ['dosages' => $dosages];
    }


    public function update(Request $request, $id): array{

        $request->validate(

            [
                'name' => 'required',
                'short_name' => 'required'
            ]

        );
        $dosage = Dosage::find($id);
        $dosage->name = $request->name;
        $dosage->short_name = $request->short_name;
        $dosage->save();

        return [
            'message' =>'Update successful',
            'data' => [
                'id' => $dosage->id,
                'name' => $dosage->name
            ]
        ];
    }

    public function destroy($id): array{
        $dosage = Dosage::find($id);
        $dosage->delete();

        return ['message' => 'Delete successful'];
    }
}
