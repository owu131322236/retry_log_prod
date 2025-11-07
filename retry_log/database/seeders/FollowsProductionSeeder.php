<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FollowsProductionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $followees = $users->where('id', '!=', $user->id)->take(2);

            foreach ($followees as $followee) {
                DB::table('follows')->updateOrInsert([
                    'follower_id' => $user->id,
                    'followee_id' => $followee->id
                ]);
            }
        }
    }
}
