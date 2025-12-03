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
        Schema::create('bed_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submitted_report_id')->constrained('submitted_reports')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('agency_id')->constrained('agencies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('emergency_room_bed_id')->constrained('emergency_room_beds')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->strig('request_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bed_reservations');
    }
};
