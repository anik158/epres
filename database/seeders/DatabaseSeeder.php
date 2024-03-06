<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Applicable;
use App\Models\Dosage;
use App\Models\Drug;
use App\Models\Generic;
use App\Models\Pharmaceutical;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            ApplicableSeeder::class, // Ensure this is called first
        ]);

        Generic::factory(800)->create();
        Pharmaceutical::factory(12)->create();
        Dosage::factory(15)->create();
        Drug::factory(500)->create();


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
