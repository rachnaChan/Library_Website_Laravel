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
        Schema::create('contact_info', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('phone_number');
            $table->string('address');
            $table->string('websites');
            $table->string('country');
            $table->string('facebook')->nullable();
            $table->string('telegram')->nullable();
            $table->string('youtube')->nullable();
            $table->text('fax');
            
            $table->timestamps();
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_info');
    }
};
