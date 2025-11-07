<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;

class NotificationsProductionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                Notification::firstOrCreate([
                    'recipient_user_id' => $user->id,
                    'message' => "ようこそ！チャレンジを始めましょう💪",
                ],[
                    'created_at' => Carbon::now()->subDays(rand(0, 10)),
                ]);
            }
        }
    }
}
