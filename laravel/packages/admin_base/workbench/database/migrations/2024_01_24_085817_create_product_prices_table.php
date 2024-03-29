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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable(false);
            $table->decimal('price',8,2)->nullable(false);
            $table->enum('scope',['normal','discount','vip'])->default('normal');
            $table->string('describe',256)->nullable();
            $table->timestamps();

            $table->unique(['scope','product_id','price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
