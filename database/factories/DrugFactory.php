<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drug>
 */
class DrugFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'strength' => $this->faker->name,
            'dosage_form' => $this->faker->randomElement([
                'Tablet',
                'Capsule',
                'Solution',
            ]),
            'generic' => $this->faker->randomElement([
                'Paracetamol',
                'Ibuprofen',
                'Amoxicillin',
            ]),
            'company' => $this->faker->randomElement([
                'Pfizer',
                'GlaxoSmithKline',
                'Johnson & Johnson',
            ]),
            'applicable_for' => $this->faker->randomElement([
                'human',
                'species'
            ]),
        ];
    }
}
