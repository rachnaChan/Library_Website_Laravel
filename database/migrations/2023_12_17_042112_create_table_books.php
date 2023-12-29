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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('author');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('release_year');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->enum('categories_type', ['GIC', 'AMS','GIM' ,'GCA', 'GEE', 'GTR', 'OAC', 'GGG'])->nullable();


            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
