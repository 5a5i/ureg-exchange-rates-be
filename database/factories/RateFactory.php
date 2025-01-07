<?php

namespace Database\Factories;

use App\Models\Rate;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rate>
 */
class RateFactory extends Factory
{
    protected $model = Rate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'base_currency_id' => Currency::factory(),
            'target_currency_id' => Currency::factory(),
            'rate' => $this->faker->randomFloat(6, 0.1, 100),
            'effective_date' => $this->faker->date(),
        ];
    }
}
