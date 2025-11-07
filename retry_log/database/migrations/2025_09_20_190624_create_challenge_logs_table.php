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
        Schema::create('challenge_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->nullable()->constrained('challenges')->onDelete('cascade');
            $table->foreignId('status_id')->nullable()->constrained('challenge_statuses')->onDelete('set null');
            $table->timestamp('logged_at'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge_logs');
    }
};
