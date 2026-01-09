<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Public identifier (API-safe)
            $table->uuid('uuid')->unique();

            // Ownership
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexing for performance
            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
