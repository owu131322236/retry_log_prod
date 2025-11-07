<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\ContentType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $targetType = $this->faker->randomElement([Post::class, Comment::class]);
        $targetModel = $targetType::inRandomOrder()->first(); //緩衝材的な
        if (!$targetModel) {
            $targetType = Post::class;
            $targetModel = Post::inRandomOrder()->first();
        }
        $targetId = $targetModel?->id;
        $parentId = null;
        if ($targetType === Comment::class) {
            $parentId = Comment::inRandomOrder()->first()?->id;
        }
        $contentTypeId = ContentType::where('name', 'neutral')->value('id');

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'parent_id' => $parentId,
            'content' => $this->faker->sentence(),
            'content_type_id' => $contentTypeId,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
