<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('old_price', 15, 2)->nullable();
            $table->string('tag')->nullable();
            $table->string('sizes')->default('S, M, L, XL');
            $table->string('colors')->default('Trắng, Đen');
            $table->decimal('rating', 3, 2)->default(5.0);
            $table->integer('stock')->default(50);
            $table->text('variant_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
