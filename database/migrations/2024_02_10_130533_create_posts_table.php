<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('slug');
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('null');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};