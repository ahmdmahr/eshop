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
            $table->string('order_number',10)->unique();
            $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('product_id');
            $table->float('subtotal')->default(0);
            $table->float('total')->default(0);
            $table->float('coupon')->default(0)->nullable();
            // $table->integer('quantity')->default(0);
            $table->string('payment_method')->default('COD');
            $table->enum('payment_status',['paid','unpaid'])->default('unpaid');
            $table->enum('condition',['pending','processing','delivered','cancelled'])->default('pending');
            $table->float('delivery_charge')->default(0)->nullable();
            $table->text('notes')->nullable();
            $table->text('payment_details')->nullable();
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
