<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExperiencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degrees = [
            'Laurea in Medicina e Chirurgia - Università di Napoli',
            'Laurea in Medicina e Chirurgia - Università di Milano',
            'Laurea in Medicina e Chirurgia - Università di Roma',
            'Laurea in Medicina e Chirurgia - Università di Genova',
            'Laurea in Medicina e Chirurgia - Università di Trieste',
            'Laurea in Medicina e Chirurgia - Università di Torino',
        ];
        $works = [
            'Primario - Ospedale Fatebene Fratelli',
            'Medico Sala Operatoria - Ospedale Gemelli Milano',
            'Primario - Ospedale Cannizzaro di Catania',
            'Medico di Reparto - Ospedale CTO di Torino',
            'Medico di Reparto - Ospedale Oftalmico di Torino'
        ];

        foreach ([1, 2, 3, 4, 5] as $doctor_id) {
            $yearStartEducation = rand(1975, 1995);
            DB::table('experiences')->insert([
                'doctor_id' => $doctor_id,
                'name' => $degrees[rand(0, count($degrees) -1)],
                'type' => 'education',
                'start_date' => $yearStartEducation.'-'.rand(1,12).'-'.rand(1,27),
                'end_date' => ($yearStartEducation+6).'-'.rand(1,12).'-'.rand(1,27)
            ]);
            $yearStartWork = rand(1996, 2023);
            DB::table('experiences')->insert([
                'doctor_id' => $doctor_id,
                'name' => $works[rand(0, count($works) -1)],
                'type' => 'work',
                'start_date' => $yearStartWork.'-'.rand(1,12).'-'.rand(1,27),
                'end_date' => null
            ]);
        }
    }
}
