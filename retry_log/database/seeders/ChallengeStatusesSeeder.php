<?php

namespace Database\Seeders;

use App\Models\ChallengeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChallengeStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $challenge_statueses = [
                ['name' => 'success'],
                ['name' => 'fail'],
                ['name' => 'skipped']
        ];
        foreach($challenge_statueses as $challenge_statues){
            ChallengeStatus::firstOrCreate(
                [
                    'name' =>$challenge_statues['name'],
                ],
                $challenge_statues
            );
        }

    }
}
