<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    protected $model = Medicine::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 50, 1000),
            'quantity' => fake()->numberBetween(0, 100),
            'category' => fake()->randomElement(['Антибиотики', 'Обезболивающие', 'Витамины', 'Жаропонижающие']),
            'manufacturer' => fake()->company(),
            'expiry_date' => Carbon::now()->addMonths(fake()->numberBetween(1, 24)),
        ];
    }
}
