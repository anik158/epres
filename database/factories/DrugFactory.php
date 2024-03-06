<?php

namespace Database\Factories;

use App\Models\Applicable;
use App\Models\Dosage;
use App\Models\Drug;
use App\Models\Generic;
use App\Models\Pharmaceutical;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrugFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Drug::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'strength' => $this->faker->randomNumber(2),
            'dosage_form' => Dosage::all()->random()->base_name,
            'generic' => Generic::all()->random()->name,
            'company' => Pharmaceutical::all()->random()->name,
            'applicable_for' => Applicable::all()->random()->category,
        ];
    }
}
