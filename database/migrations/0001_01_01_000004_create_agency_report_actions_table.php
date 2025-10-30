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
        Schema::create('agency_report_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submitted_report_id')->constrained('submitted_reports')->onDelete('cascade')->onUpdate('cascade');
            $table->string('shortestpath_trigger_num');
            $table->float('incident_longitude');
            $table->float('incident_latitude');
            $table->string('nearest_agency_name');
            $table->string('agency_type');
            $table->float('agency_longitude');
            $table->float('agency_latitude');
            $table->string('report_action');
            $table->string('decline_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_report_actions');
    }
};
