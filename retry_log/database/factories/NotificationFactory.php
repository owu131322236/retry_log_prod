<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Enums\NotificationActionType;
use App\Models\Challenge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $targetClass = $this->faker->randomElement([Challenge::class, Post::class, Comment::class ]);
        $target = $targetClass::inRandomOrder()->first();
        $actionType = $this->faker->randomElement(NotificationActionType::cases());
        return [
            'recipient_user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'actor_user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'target_type' => $targetClass, 
            'target_id' => $target?->id,
            'action_type' => $actionType,
            'group_key' => $target ? strtolower(class_basename($targetClass)) . ":" . $target->id . ":" . $actionType->value : null,
            'payload' => ['message' => $this->faker->sentence()],
            'read_at' => $this->faker->boolean(20) ? now() : null,
            'notified_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
