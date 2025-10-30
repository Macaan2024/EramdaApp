<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agency>
 */
class AgencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $agencyNames = [
            'Bureau of Fire Protection in the Philippines (BFP)',
            'City Disaster Risk Reduction and Management Office (CDRRMO)',
            'Barangay Disaster Risk Reduction and Management Committee (BDRRMC)',
            'Hospitals'
        ];

        return [
            'agencyNames'  => $this->faker->randomElement($agencyNames),

        ];
    }
}
