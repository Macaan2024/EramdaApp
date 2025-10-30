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
        Schema::create('evacuation_areas', function (Blueprint $table) {
            $table->id();
            $table->string('center_name');
            $table->string('center_head_name');
            $table->float('center_longitude');
            $table->float('center_latitude');
            $table->integer('maximum_capacity');
            $table->integer('current_capacity');
            $table->string('center_availability_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evacuation_areas');
    }
};
