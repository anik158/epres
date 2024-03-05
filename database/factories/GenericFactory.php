<?php

namespace Database\Factories;

use App\Models\Generic;
use App\Models\Applicable;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenericFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Generic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'composition' => $this->faker->sentence,
            'indications' => $this->faker->sentence,
            'therapeutic_class' => $this->faker->sentence,
            'pharmacology' => $this->faker->sentence,
            'dosage' => $this->faker->sentence,
            'administration' => $this->faker->sentence,
            'interaction' => $this->faker->sentence,
            'contraindications' => $this->faker->sentence,
            'side_effects' => $this->faker->sentence,
            'pregnancy_lactation' => $this->faker->sentence,
            'precautions' => $this->faker->sentence,
            'pediatric_use' => $this->faker->sentence,
            'overdose_effects' => $this->faker->sentence,
            'reconstitution' => $this->faker->sentence,
            'storage_condition' => $this->faker->sentence,
            'applicable_for' => Applicable::all()->random()->category,
        ];
    }

}
