<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach($users as $user){
            $followees = $users->where('id', '!=', $user->id)
            ->random(rand(2,4))
            ->pluck('id');
            foreach($followees as $follweeId){
                DB::table('follows')->updateOrInsert(
                    [
                        'follower_id' => $user->id,
                        'followee_id' => $follweeId
                    ],
                    []
                );
            }
        }
    }
}
