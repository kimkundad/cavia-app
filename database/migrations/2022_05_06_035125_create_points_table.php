<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->string('user_key')->nullable();
            $table->string('date')->nullable();
            $table->double('total_valid_bet_amount', 15, 2)->default('0.0');
            $table->integer('type')->default('0');
            $table->integer('status')->default('0');
            $table->double('point', 15, 2)->default('0.0');
            $table->double('last_point', 15, 2)->default('0.0');
            $table->text('detail')->nullable();
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
        Schema::dropIfExists('points');
    }
}
