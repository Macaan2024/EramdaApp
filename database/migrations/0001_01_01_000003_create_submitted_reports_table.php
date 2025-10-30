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
        Schema::create('submitted_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('incident_category');
            $table->string('incident_type');
            $table->string('barangay_name');
            $table->string('city_name');
            $table->string('purok')->nullable();
            $table->string('street_name')->nullable();
            $table->string('barangay_longitude');
            $table->string('barangay_latitude');
            $table->string('alarm_level');
            $table->string('vehicle_type_request');
            $table->integer('police_car_request')->nullable();
            $table->integer('fire_truck_request')->nullable();
            $table->integer('ambulance_request')->nullable();
            $table->string('report_status');
            $table->string('reported_by');
            $table->string('from_agency');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('submitted_reports');
    }
};
