<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncidentType>
 */
class IncidentTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define possible incidents by category
        $incidents = [
            'Disaster Incident' => [
                'Fire',
                'Flood',
                'Earthquake',
                'Typhoon',
                'Landslide',
            ],
            'Road Accident' => [
                'Car Collision',
                'Motorcycle Crash',
                'Truck Accident',
                'Pedestrian Hit',
                'Highway Pile-up',
            ],
        ];

        // Randomly pick a category
        $category = $this->faker->randomElement(array_keys($incidents));

        // Randomly pick an incident name from that category
        $incident_name = $this->faker->randomElement($incidents[$category]);

        return [
            'incident_name' => $incident_name,
            'category'      => $category,
        ];
    }
}
