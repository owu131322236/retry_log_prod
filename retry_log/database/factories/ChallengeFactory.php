<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Challenge;
use App\Enums\ChallengeState;
use App\Enums\ChallengeFrequency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'state' => $this->faker->randomElement(ChallengeState::cases())->value,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'start_date' => $startDate,
            'end_date' => $this->faker->dateTimeBetween($startDate, '+6 months'),
            'frequency_type' => $this->faker->randomElement(ChallengeFrequency::cases())->value,
            'frequency_goal' => rand(1, 5),
            'interrupted_at' => $this->faker->boolean(20) ? $this->faker->dateTimeBetween('-10 days', 'now') : null,
        ];
    }
}
