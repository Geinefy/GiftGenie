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
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_uuid')->unique(); // For anonymous users
            $table->text('initial_prompt');
            $table->json('context')->nullable(); // Store chat context
            $table->json('ai_response')->nullable(); // Store AI response
            $table->integer('gifts_found')->default(0);
            $table->decimal('total_budget_shown', 10, 2)->default(0);
            $table->string('status')->default('active'); // active, completed, archived
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
    }
};
