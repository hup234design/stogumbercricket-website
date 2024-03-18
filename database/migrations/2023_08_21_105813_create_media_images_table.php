<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('media_images', function (Blueprint $table) {
            $table->id();
            $table->string("original_filename");
            $table->text("alt")->nullable();
            $table->text("caption")->nullable();
            $table->json("conversions")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_images');
    }
};
