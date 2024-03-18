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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('order_column')->default(1);
            $table->foreignId('slider_id')->constrained()->cascadeOnDelete();
            $table->string('heading');
            $table->string('subheading')->nullable();
            $table->text('text')->nullable();
            $table->foreignId('media_image_id')->nullable()->constrained()->nullOnDelete();
            $table->json('links')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
