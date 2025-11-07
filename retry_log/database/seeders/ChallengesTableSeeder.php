<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Challenge;
use App\Models\ChallengeLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChallengesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function($user){
            Challenge::factory()->count(10)->create()->each(function($challenge){
                ChallengeLog::factory()->count(rand(0,20))->create([
                    'challenge_id' => $challenge->id, //ChallengeLogのchallenge_idを紐づける
                ]);
            });
        });
    }
        
}
