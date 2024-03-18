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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('opponent_id')->constrained()->cascadeOnDelete();
            $table->foreignId('venue_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('home')->default(true);
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->boolean('cancelled')->default(false);
            $table->string('result')->nullable();
            $table->string('runs')->nullable();
            $table->string('overs')->nullable();
            $table->string('wickets')->nullable();
            $table->string('note')->nullable();
            $table->string('opponent_runs')->nullable();
            $table->string('opponent_overs')->nullable();
            $table->string('opponent_wickets')->nullable();
            $table->string('opponent_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
