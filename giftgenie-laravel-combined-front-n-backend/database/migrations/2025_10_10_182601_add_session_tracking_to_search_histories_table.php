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
        Schema::table('search_histories', function (Blueprint $table) {
            $table->string('session_uuid')->nullable()->after('prompt');
            $table->integer('results_count')->default(0)->after('session_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('search_histories', function (Blueprint $table) {
            $table->dropColumn(['session_uuid', 'results_count']);
        });
    }
};
