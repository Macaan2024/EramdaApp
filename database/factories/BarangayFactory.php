<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barangay>
 */
class BarangayFactory extends Factory
{
    public function definition(): array
    {
        // List of barangays in Iligan
        $barangays = [
            'Abuno',
            'Acmac-Mariano Badelles Sr.',
            'Bagong Silang',
            'Bonbonon',
            'Bunawan',
            'Buru-un',
            'Dalipuga',
            'Del Carmen',
            'Digkilaan',
            'Ditucalan',
            'Dulag',
            'Hinaplanon',
            'Hindang',
            'Kabacsanan',
            'Kalilangan',
            'Kiwalan',
            'Lanipao',
            'Luinab',
            'Mahayahay',
            'Mainit',
            'Mandulog',
            'Maria Cristina',
            'Pala-o',
            'Panoroganan',
            'Poblacion',
            'Puga-an',
            'Rogongon',
            'San Miguel',
            'San Roque',
            'Santiago',
            'Saray',
            'Santa Elena',
            'Santa Filomena',
            'Santo Rosario',
            'Suarez',
            'Tambacan',
            'Tibanga',
            'Tipanoy',
            'Tomas L. Cabili (Tominobo Proper)',
            'Tubod',
            'Ubaldo Laya',
            'Upper Hinaplanon',
            'Upper Tominobo',
            'Villa Verde',
        ];

        return [
            'barangayNames' => fake()->unique()->randomElement($barangays),
            'city'          => 'Iligan City',
            'longitude'     => fake()->longitude(124.0, 125.0),
            'latitude'      => fake()->latitude(8.0, 9.0),
        ];
    }
}
