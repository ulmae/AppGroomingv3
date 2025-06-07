<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('work_order_services', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->uuid('work_order_id');
            $table->unsignedBigInteger('service_id');
            $table->integer('order_index')->nullable();
            
            $table->foreign('work_order_id')->references('id')->on('work_orders');
            $table->foreign('service_id')->references('id')->on('grooming_services');
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_order_services');
    }
};