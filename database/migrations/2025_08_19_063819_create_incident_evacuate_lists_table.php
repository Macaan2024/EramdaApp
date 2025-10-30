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
        Schema::create('incident_evacuate_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evacuation_area_id')->constrained('evacuation_areas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('incident_id')->constrained('incidents')->onUpdate('cascade')->onDelete('cascade');
            $table->string('family_father_name');
            $table->string('family_mother_name');
            $table->integer('family_total_members');
            $table->integer('family_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_evacuate_lists');
    }
};
