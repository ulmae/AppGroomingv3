<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('breed_cut_styles', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('breed', 100);
            $table->string('name', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('image_url', 500)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('breed_cut_styles');
    }
};