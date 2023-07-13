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
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->constrained('truck');
            $table->date('maintenance_date'); //Ngày bảo dưỡng.
            $table->string('maintenance_description'); //Mô tả bảo dưỡng.
            $table->decimal('maintenance_cost', 10, 2); //Chi phí bảo dưỡng.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_maintenance_records');
    }
};
