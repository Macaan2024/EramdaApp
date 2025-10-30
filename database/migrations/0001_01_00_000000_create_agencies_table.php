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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('agencyNames')->unique();
            $table->string('agencyTypes');
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('city');
            $table->string('barangay');
            $table->string('address');
            $table->string('zipcode');
            $table->string('email')->unique();
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
            $table->string('availabilityStatus');
            $table->string('logo', 2080)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
