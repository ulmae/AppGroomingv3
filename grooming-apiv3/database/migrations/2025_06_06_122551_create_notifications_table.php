<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id');
            $table->enum('type', ['sms', 'email', 'WhatsApp']);
            $table->text('message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->uuid('related_order')->nullable();
            
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('related_order')->references('id')->on('work_orders');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};