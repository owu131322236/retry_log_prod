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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('target_type');
            $table->unsignedBigInteger('target_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->foreignId('content_type_id')->nullable()->constrained('content_types')->restrictOnDelete()
            ->default(function () {
                return \App\Models\ContentType::where('name', 'neutral')->value('id');
            });
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
