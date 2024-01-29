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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title',32)->nullable(false)->comment('标题名称');
            $table->string('name',32)->nullable(false)->comment('标识名称');
            $table->string('remark',512)->nullable()->comment('备注');
            $table->boolean('is_active')->nullable(false)->defaut(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
