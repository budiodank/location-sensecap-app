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
        Schema::create('tbl_device', function (Blueprint $table) {
            $table->string('device_uuid', 50)->primary();
            $table->string('device_name');
            $table->enum('online_status', ['Online', 'Offline']);
            $table->string('node_eui', 100)->unique();
            $table->string('created_by', 100);
            $table->string('updated_by', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_device');
    }
};
