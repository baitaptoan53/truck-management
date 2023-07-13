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
        Schema::create('truck', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer'); //Hãng xe tải.
            $table->string('model'); //Model xe tải.
            $table->year('year'); //Năm sản xuất.
            $table->string('license_plate'); //Biển số xe tải.
            $table->string('vin_number'); //Số khung.
            $table->date('purchase_date'); //Ngày mua xe tải.
            $table->date('registration_date'); //Ngày đăng ký xe tải.
            $table->integer('curent_mileage'); //Số km hiện tại.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck');
    }
};
