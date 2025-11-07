<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ReactionType;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\ContentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reaction>
 */
class ReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $target = collect([
            Post::inRandomOrder()->first(),
            Comment::inRandomOrder()->first(),
        ])
        ->filter() 
        ->filter(function ($t) {
            $contentTypeId = $t instanceof Post
                ? $t->content_type_id
                : ContentType::where('name', 'neutral')->value('id');
            return ReactionType::forContentType($contentTypeId)->exists();
        })
        ->random();
        $contentTypeId = $target instanceof Post
            ? $target->content_type_id
            : ContentType::where('name', 'neutral')->value('id');
    
        $reactionTypeId = ReactionType::forContentType($contentTypeId)
            ->inRandomOrder()
            ->value('id');
        return [
            'user_id'          => $target->user_id,
            'target_type'      => get_class($target),
            'target_id'        => $target->id,
            'reaction_type_id' => $reactionTypeId,
        ];
    }
}
