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
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->index();
            $table->string('state')->nullable()->default('in_progress');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->string('frequency_type')->default('daily');
            $table->unsignedInteger('frequency_goal')->default(1);
            $table->unsignedInteger('current_streak')->default(0);
            $table->unsignedInteger('max_streak')->default(0);
            $table->unsignedInteger('achievement_rate')->nullable()->default(0);
            $table->timestamp('interrupted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
