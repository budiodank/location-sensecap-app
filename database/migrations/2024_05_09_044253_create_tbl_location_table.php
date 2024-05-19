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
        Schema::create('tbl_location', function (Blueprint $table) {
            $table->id();
            $table->string('longitude', 50)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('node_eui', 100);
            $table->dateTime('created_tm', precision: 0);
            $table->dateTime('created_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_location');
    }
};
