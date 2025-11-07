<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    Post::all()->each(function($post){
        for($i=0; $i<rand(0,10); $i++){
            $reaction = Reaction::factory()->make([
                'target_type' => get_class($post),
                'target_id' =>$post->id
            ]);
            if (!$post) continue; 
            Reaction::firstOrCreate([
                'user_id' => $reaction->user_id,
                'reaction_type_id' => $reaction->reaction_type_id,
                'target_type' => $reaction->target_type,
                'target_id' => $reaction->target_id,
            ],
            $reaction->toArray()
            );
        }
    });
    Comment::all()->each(function($comment){
        for($i=0; $i<rand(0,10); $i++){
            $reaction = Reaction::factory()->make([
                'target_type' => get_class($comment),
                'target_id' =>$comment->id
            ]);
            if (!$comment) continue; 
            Reaction::firstOrCreate([
                'user_id' => $reaction->user_id,
                'reaction_type_id' => $reaction->reaction_type_id,
                'target_type' => $reaction->target_type,
                'target_id' => $reaction->target_id,
            ],
            $reaction->toArray()
            );
        }
    });
    }
}
