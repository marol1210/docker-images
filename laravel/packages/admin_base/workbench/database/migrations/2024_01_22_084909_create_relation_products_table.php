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
        Schema::create('relation_products', function (Blueprint $table) {
            $table->integer('product_id')->nullable(false)->comment('商品ID');
            $table->integer('product_category_id')->nullable(false)->comment('商品类别ID');
            $table->unique(['product_id','product_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relation_products');
    }
};
