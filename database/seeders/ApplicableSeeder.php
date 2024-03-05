<?php

namespace Database\Seeders;

use App\Models\Applicable;
use Illuminate\Database\Seeder;

class ApplicableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Applicable::create(['category' => 'human']);
        Applicable::create(['category' => 'species']);
    }
}
