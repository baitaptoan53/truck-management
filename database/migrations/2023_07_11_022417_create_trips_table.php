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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->constrained('truck');
            $table->foreignId('user_id')->constrained('users');
            $table->date('start_date'); //Ngày bắt đầu chuyến đi.
            $table->date('end_date'); //Ngày kết thúc chuyến đi.
            $table->string('start_location'); //Điểm bắt đầu.
            $table->string('end_location'); //Điểm kết thúc.
            $table->decimal('total_distance', 10, 2); //Tổng quãng đường đi.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
