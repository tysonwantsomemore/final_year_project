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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('status')->default('Pending'); // Pending, Processing, Shipping, Completed, Cancelled
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->text('customer_note')->nullable();
            $table->string('payment_method')->default('cod'); // cod, bank
            $table->string('payment_status')->default('Unpaid'); // Paid, Unpaid
            $table->decimal('total_amount', 15, 2);
            $table->decimal('shipping_fee', 15, 2)->default(0);
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->onDelete('set null');
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
