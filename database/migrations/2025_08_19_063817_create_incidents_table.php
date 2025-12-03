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
            $table->string('severity_level')->nullable();
            $table->string('incident_region')->nullable();
            $table->string('incident_province')->nullable();
            $table->string('incident_city')->nullable();
            $table->string('incident_longitude')->nullable();
            $table->string('incident_latitude')->nullable();
            $table->string('incident_cause')->nullable();
            $table->string('incident_description')->nullable();
            $table->string('remarks')->nullable();
            $table->string('incident_status')->nullable();
            $table->integer('num_vehicles')->nullable();
            $table->integer('num_driver_casualties')->nullable();
            $table->integer('num_pedestrian_casualties')->nullable();
            $table->integer('num_passenger_casualties')->nullable();
            $table->integer('num_driver_injured')->nullable();
            $table->integer('num_pedestrian_injured')->nullable();
            $table->integer('num_passenger_injured')->nullable();
            $table->string('junction_type')->nullable();
            $table->string('collision_type')->nullable();
            $table->string('weather_condition')->nullable();
            $table->string('light_condition')->nullable();
            $table->string('road_character')->nullable();
            $table->string('surface_condition')->nullable();
            $table->string('surface_type')->nullable();
            $table->string('main_cause')->nullable();
            $table->string('road_class')->nullable();
            $table->string('road_repairs')->nullable();
            $table->string('road_name')->nullable();
            $table->string('location_name')->nullable();
            $table->string('hit_and_run')->nullable();
            $table->string('case_status')->nullable();
            $table->string('reported_by')->nullable();
            $table->string('response_lead_agency')->nullable();
            $table->string('investigating_officer')->nullable(); //
            $table->string('supervising_officer')->nullable(); //
            $table->string('recommendation')->nullable();
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
