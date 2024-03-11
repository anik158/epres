<?php

namespace App\Drugs;

use Illuminate\Pagination\LengthAwarePaginator;

interface DrugRepository
{
    public function search(String $query): LengthAwarePaginator;
}
