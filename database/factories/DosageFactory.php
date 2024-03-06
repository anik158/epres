<?php

namespace Database\Factories;

use App\Models\Dosage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DosageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dosage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'short_name' => $this->faker->word,
            'base_name' => $this->faker->word,
            'image' => $this->faker->image('public/storage/uploads/dosages',60,60, null, false) // 'public/storage/uploads/dosages' is the path where the image will be saved. 640 and 480 are the width and height of the image. Setting the last parameter to false will return the relative filepath.
        ];
    }
}
