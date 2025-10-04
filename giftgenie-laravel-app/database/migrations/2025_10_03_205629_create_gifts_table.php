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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->decimal('min_price', 8, 2)->nullable();
            $table->decimal('max_price', 8, 2)->nullable();
            $table->string('recipient')->nullable(); // friend, mother, colleague, etc.
            $table->string('occasion'); // birthday, graduation, wedding, etc.
            $table->string('country')->nullable(); // Bangladesh, USA, UK, India, Canada, Australia
            $table->string('category')->nullable(); // electronics, books, jewelry, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
