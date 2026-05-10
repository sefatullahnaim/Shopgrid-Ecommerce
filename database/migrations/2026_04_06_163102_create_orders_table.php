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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('courier_id')->default(0);
            $table->float('order_total');
            $table->float('tax_total');
            $table->float('shipping_total');
            $table->string('order_status')->default('Pending');
            $table->text('order_date');
            $table->text('order_timestamp');
            $table->text('delivery_address');
            $table->text('delivery_date')->nullable();
            $table->text('delivery_timestamp')->nullable();
            $table->string('delivery_status')->default('Pending');
            $table->string('payment_method');
            $table->float('payment_amount')->default(0);
            $table->text('payment_date')->nullable();
            $table->text('payment_timestamp')->nullable();
            $table->string('payment_status')->default('Pending');
            $table->string('currency')->default('BDT');
            $table->text('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
