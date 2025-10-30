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
        Schema::create('individual_er_bed_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->nullable()->constrained('incidents')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('individual_id')->constrained('individuals')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('emergency_room_bed_id')->constrained('emergency_room_beds')->onUpdate('cascade')->onDelete('cascade');
            $table->string('admit_status'); // Pending / Admitted / Discharge
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_er_bed_lists');
    }
};
