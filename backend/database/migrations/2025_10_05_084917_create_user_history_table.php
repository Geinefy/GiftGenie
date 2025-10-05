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
        Schema::create('user_history', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable(); // Allow anonymous users initially
            $table->text('query'); // User's search query
            $table->json('ai_response'); // AI response from Gemini
            $table->json('fetched_items'); // Products fetched from scraping
            $table->string('session_id')->nullable(); // For anonymous session tracking
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('session_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_history');
    }
};
