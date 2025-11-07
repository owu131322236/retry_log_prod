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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('icon_id')->nullable()->constrained('images')->onDelete('cascade');
            $table->foreignId('background_id')->nullable()->constrained('images')->onDelete('cascade');
            $table->string('bio')->nullable();
            $table->integer('points')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['icon_id']);
            $table->dropForeign(['background_id']);

            $table->dropColumn(['icon_id','background_id', 'bio', 'points']);
            $table->dropSoftDeletes();
        });
    }
};
