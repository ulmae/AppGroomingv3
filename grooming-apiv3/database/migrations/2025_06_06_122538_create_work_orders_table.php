<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pet_id');
            $table->uuid('created_by_id');
            $table->uuid('assigned_to_id');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled']);
            $table->timestamp('estimated_ready')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->boolean('customer_notified')->default(false);
            $table->text('comments')->nullable();
            $table->timestamps();
            
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->foreign('created_by_id')->references('id')->on('users');
            $table->foreign('assigned_to_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_orders');
    }
};