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
        // đổi cột purchase_date từ date sang datetime
        Schema::table('truck', function (Blueprint $table) {
            $table->dateTime('purchase_date')->change();
            $table->dateTime('registration_date')->change();
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
