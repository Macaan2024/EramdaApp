<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmergencyVehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicleTypes'       => $this->faker->randomElement(['Ambulance', 'Fire Truck', 'Police Car']),
            'plateNumber'        => strtoupper($this->faker->bothify('??-####')), // e.g. AB-1234
            'vehicle_photo'      => null, // default null for now
            'availabilityStatus' => $this->faker->randomElement(['Available', 'Unavailable', 'In Maintenance']),
        ];
    }
}
