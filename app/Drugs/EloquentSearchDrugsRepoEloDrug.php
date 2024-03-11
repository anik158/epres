<?php

namespace App\Drugs;

use App\Models\Drug;
use Illuminate\Pagination\LengthAwarePaginator;


class EloquentSearchDrugsRepoEloDrug implements DrugRepository
{

    public function search(String $query): LengthAwarePaginator
    {

        return  Drug::where('name', 'like', '%' . $query . '%')
            ->orWhere('generic', 'like', '%' . $query . '%')
            ->paginate(40);

    }
}
