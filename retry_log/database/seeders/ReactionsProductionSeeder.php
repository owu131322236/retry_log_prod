<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reaction;
use App\Models\Post;
use App\Models\Comment;
use App\Models\ReactionType;

class ReactionsProductionSeeder extends Seeder
{
    public function run(): void
    {
        $reactionTypes = ReactionType::pluck('id')->toArray();
        $users = \App\Models\User::pluck('id')->toArray();

        Post::all()->each(function($post) use ($reactionTypes, $users) {
            $count = rand(1, 3);
            for ($i = 0; $i < $count; $i++) {
                Reaction::firstOrCreate([
                    'user_id' => $users[array_rand($users)],
                    'reaction_type_id' => $reactionTypes[array_rand($reactionTypes)],
                    'target_type' => Post::class,
                    'target_id' => $post->id,
                ]);
            }
        });

        Comment::all()->each(function($comment) use ($reactionTypes, $users) {
            $count = rand(0, 2);
            for ($i = 0; $i < $count; $i++) {
                Reaction::firstOrCreate([
                    'user_id' => $users[array_rand($users)],
                    'reaction_type_id' => $reactionTypes[array_rand($reactionTypes)],
                    'target_type' => Comment::class,
                    'target_id' => $comment->id,
                ]);
            }
        });
    }
}
