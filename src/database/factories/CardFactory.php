<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scryfall_card_id' => $this->faker->uuid,
            'name' => $this->faker->word,
            'set_code' => $this->faker->word,
            'image_path' => $this->faker->imageUrl(640, 480, 'cards', true, 'Faker'),
            'created_at' => now()
        ];
    }
}
