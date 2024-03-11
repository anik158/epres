<?php

namespace App\Drugs;


use Illuminate\Pagination\LengthAwarePaginator;

interface SearchEloDrugRepository
{

    public function search(String $query): LengthAwarePaginator;
}
