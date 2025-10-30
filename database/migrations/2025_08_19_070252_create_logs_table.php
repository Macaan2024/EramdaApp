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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->onUpdate('cascade')->onDelete('cascade');
            $table->string('modified_by')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('interaction_type');
            $table->foreignId('emergency_vehicle_id')->nullable()->constrained('emergency_vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('individual_id')->nullable()->constrained('individuals')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('attendance_id')->nullable()->constrained('attendances')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('deployment_list_id')->nullable()->constrained('deployment_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('treatment_service_id')->nullable()->constrained('treatment_services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('submitted_report_id')->nullable()->constrained('submitted_reports')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agency_report_action_id')->nullable()->constrained('agency_report_actions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('emergency_room_bed_id')->nullable()->constrained('emergency_room_beds')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('incident_id')->nullable()->constrained('incidents')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
