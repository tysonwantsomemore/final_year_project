<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('fee', 15, 2)->default(0);
            $table->string('estimated_days');
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('discount_type'); // percent, fixed
            $table->decimal('discount_value', 15, 2);
            $table->decimal('min_order_amount', 15, 2)->default(0);
            $table->decimal('max_discount_amount', 15, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_limit_per_user')->nullable();
            $table->integer('used_count')->default(0);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_address_id')->nullable()->constrained('user_addresses')->onDelete('set null');
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->onDelete('set null');
            $table->foreignId('shipping_method_id')->nullable()->constrained('shipping_methods')->onDelete('set null');
            $table->string('order_code')->unique();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->text('shipping_address_snapshot');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('shipping_fee', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_method'); // cod, bank, online_vnpay
            $table->string('payment_status')->default('Unpaid'); // Paid, Unpaid, Refunded
            $table->string('order_status')->default('Pending'); // Pending, Processing, Shipping, Completed, Cancelled
            $table->text('note')->nullable();
            $table->string('cancelled_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('restrict');
            $table->string('product_name_snapshot');
            $table->string('sku_snapshot');
            $table->string('size_name_snapshot');
            $table->string('color_name_snapshot');
            $table->integer('quantity');
            $table->decimal('price_at_purchase', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('voucher_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained('vouchers')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->decimal('discount_amount', 15, 2);
            $table->timestamp('used_at')->useCurrent();
            $table->unique(['voucher_id', 'order_id']);
        });

        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('shipping_method_id')->constrained('shipping_methods')->onDelete('restrict');
            $table->string('carrier_name');
            $table->string('tracking_code')->nullable();
            $table->string('shipping_status')->default('Pending'); // Pending, Shipped, Delivered, Returned
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('method');
            $table->decimal('amount', 15, 2);
            $table->string('transaction_code')->nullable();
            $table->string('status')->default('Pending'); // Pending, Success, Failed
            $table->dateTime('paid_at')->nullable();
            $table->text('raw_response')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('old_status');
            $table->string('new_status');
            $table->text('note')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
        Schema::dropIfExists('payment_transactions');
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('voucher_usages');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('shipping_methods');
    }
};
