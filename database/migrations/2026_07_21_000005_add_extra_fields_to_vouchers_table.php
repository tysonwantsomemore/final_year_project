<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->decimal('discount_amount', 15, 2)->nullable()->after('discount_percent');
            $table->integer('used_count')->default(0)->after('usage_limit');
            $table->boolean('new_customer_only')->default(false)->after('used_count');
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn(['discount_amount', 'used_count', 'new_customer_only']);
        });
    }
};
