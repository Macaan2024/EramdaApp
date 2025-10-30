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
        Schema::create('individuals', function (Blueprint $table) {
            $table->id();
            $table->string('individual_name');
            $table->string('individual_address');
            $table->string('individual_sex');
            $table->string('individual_contact_number');
            $table->string('injury_status');
            $table->string('transportation_type');
            $table->string('first_aid_applied'); // Addmitted, Release. Given First Aid
            $table->string('incident_position'); //seat position (for  passenger) or standing location
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individuals');
    }
};
