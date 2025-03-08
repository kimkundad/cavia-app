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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable(); // ID ของ Admin
            $table->string('action'); // กิจกรรมที่ทำ เช่น "เปลี่ยนสถานะ Credit"
            $table->text('details')->nullable(); // รายละเอียดเพิ่มเติม
            $table->timestamps();

            // เชื่อมกับ users table (เฉพาะ Admin)
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
