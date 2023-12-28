<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',32)->nullable(false)->comment("商品名称");
            $table->string('describe',256)->nullable(false)->comment("商品描述");
            $table->unsignedMediumInteger('creater_id')->nullable(false)->comment("创建人ID");
            $table->timestamps();
            $table->comment= '商品';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
