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
        Schema::create('reaction_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_type_id')->nullable()->constrained('content_types')->restrictOnDelete();
            $table->string('emoji');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_special')->default(false);
            $table->integer('point_cost')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reaction_types');
    }
};
