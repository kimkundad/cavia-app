<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // เปลี่ยนเป็น unsignedBigInteger
            $table->unsignedBigInteger('product_id')->nullable(); // เปลี่ยนเป็น unsignedBigInteger
            $table->integer('point')->default(0);
            $table->integer('credit')->default(0);
            $table->integer('lastPoint')->default(0);
            $table->integer('status')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits');
    }
};
