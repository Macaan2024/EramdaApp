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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submitted_report_id')->constrained('submitted_reports')->onUpdate('cascade')->onDelete('cascade');
            $table->string('severity_level');
            $table->string('incident_region');
            $table->string('incident_province');
            $table->string('incident_city');
            $table->string('incident_longitude')->nullable();
            $table->string('incident_latitude')->nullable();
            $table->string('incident_cause');
            $table->string('incident_description');
            $table->string('remarks');
            $table->string('incident_status');
            $table->integer('num_vehicles');
            $table->integer('num_driver_casualties');
            $table->integer('num_pedestrian_casualties');
            $table->integer('num_passenger_casualties');
            $table->integer('num_driver_injured');
            $table->integer('num_pedestrian_injured');
            $table->integer('num_passenger_injured');
            $table->string('junction_type');
            $table->string('collision_type');
            $table->string('weather_condition');
            $table->string('light_condition');
            $table->string('road_character');
            $table->string('surface_condition');
            $table->string('surface_type');
            $table->string('main_cause');
            $table->string('road_class');
            $table->string('road_repairs');
            $table->string('road_name');
            $table->string('location_name');
            $table->string('hit_and_run');
            $table->string('case_status');
            $table->string('reported_by');
            $table->string('response_lead_agency');
            $table->string('investigating_officer'); //
            $table->string('supervising_officer'); //
            $table->string('recommendation');
            $table->string('action_taken');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
