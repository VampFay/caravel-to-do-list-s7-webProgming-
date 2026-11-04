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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Untitled Note');
            $table->longText('content')->nullable();
            $table->string('color')->default('default')->index();
            $table->boolean('is_pinned')->default(false)->index();
            $table->string('category')->nullable()->index();
            $table->foreignId('todo_id')->nullable()->constrained('todos')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
