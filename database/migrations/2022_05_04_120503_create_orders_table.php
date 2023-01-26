<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('order_no')->nullable();
            $table->string('track_no')->nullable();
            $table->string('sum_point')->nullable();
            $table->text('name_product')->nullable();
            $table->string('shipping')->nullable();
            $table->string('name_order')->nullable();
            $table->string('gift')->nullable();
            $table->string('telephone_order')->nullable();
            $table->text('address')->nullable();
            $table->string('shipping_price')->nullable();
            $table->text('note')->nullable();
            $table->integer('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
