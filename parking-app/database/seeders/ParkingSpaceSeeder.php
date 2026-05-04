<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParkingSpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = [];

        // Créer 20 places de parking (P1 à P20)
        for ($i = 1; $i <= 20; $i++) {
            $places[] = [
                'numero_place' => 'P' . $i,
                'disponible' => true,
                'type_place' => 'normal',
            ];
        }

        // Ajouter 2 places PMR
        $places[] = ['numero_place' => 'PMR1', 'disponible' => true, 'type_place' => 'pmr'];
        $places[] = ['numero_place' => 'PMR2', 'disponible' => true, 'type_place' => 'pmr'];

        // Ajouter 2 places réservées
        $places[] = ['numero_place' => 'RES1', 'disponible' => true, 'type_place' => 'reserve'];
        $places[] = ['numero_place' => 'RES2', 'disponible' => true, 'type_place' => 'reserve'];

        foreach ($places as $place) {
            \App\Models\ParkingSpace::create($place);
        }
    }
}
