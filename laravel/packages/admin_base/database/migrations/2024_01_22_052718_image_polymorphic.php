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
        //
        Schema::create('image_polymorphic', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable(false)->comment('图片URl');
            $table->enum('use_as', ['cover', 'detail'])->nullable(false)->comment('图片使用方式  cover:封面图(只能一张)   detial:详情列表图(多张)');
            $table->tinyInteger('is_active')->nullable(false)->default(0)->comment('0:未激活 1:激活');
            $table->string('imageable_id')->nullable(false)->comment('imageable_type对应的ID');
            $table->string('imageable_type')->nullable(false)->comment('具体对应类');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::drop('image_polymorphic');
    }
};
