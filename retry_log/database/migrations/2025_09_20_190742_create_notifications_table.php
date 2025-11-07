<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipient_user_id')->constrained('users')->onDelete('cascade')->index()->name('fk_notifications_recipient_user_id');
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->onDelete('set null')->name('fk_notifications_actor_user_id');
            $table->string('target_type');
            $table->unsignedBigInteger('target_id');
            $table->string('action_type');
            $table->string('group_key')->nullable();
            $table->json('payload')->nullable();
            $table->date('read_at')->nullable()->index();
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
