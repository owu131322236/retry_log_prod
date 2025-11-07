<?php

namespace Database\Factories;

use App\Models\ChallengeLog;
use App\Models\Challenge;
use App\Models\ChallengeStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChallengeLog>
 */
class ChallengeLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'challenge_id' => Challenge::inRandomOrder()->first()->id ?? Challenge::factory(),
            'status_id' => ChallengeStatus::inRandomOrder()->first()->id ?? ChallengeStatus::factory(),
            'logged_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
