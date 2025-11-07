<?php

namespace Database\Seeders;

use App\Models\ChallengeStatus;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //共通部分(状態テーブルなど)
        $this->call([
            ChallengeStatusesSeeder::class,
            ContentTypesSeeder::class,
            ReactionTypesSeeder::class,
            ImageSeeder::class,
        ]);
        if (app()->environment('local')) {
            $this->call(LocalSeeder::class);
        }
        if (app()->environment('production')) {
            $this->call(ProductionDemoSeeder::class);
        }
    }
}
