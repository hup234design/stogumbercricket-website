<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('order_column')->default(0);
            $table->string("title");
            $table->string("slug");
            $table->text("description")->nullable();
            $table->foreignId('featured_image_id')->nullable()->constrained('media_images')->nullOnDelete();
            $table->foreignId('header_image_id')->nullable()->constrained('media_images')->nullOnDelete();
            $table->foreignId('seo_image_id')->nullable()->constrained('media_images')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_categories');
    }
};
