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
        $degrees = config("educationExperiences");
        $works = config("workExperience");
        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100];


        foreach ($numbers as $doctor_id) {
            $randNumber = rand(0, count($degrees) -1);

            DB::table('experiences')->insert([
                'doctor_id' => $doctor_id,
                'name' => $degrees[$randNumber]['name'],
                'type' => 'education',
                'start_date' => $degrees[$randNumber]['start_date'],
                'end_date' => $degrees[$randNumber]["end_date"]
            ]);

            $randNumber1 = rand(0, count($degrees) -1);

            if($works[$randNumber1]['end_date'] != '')
            {
                DB::table('experiences')->insert([
                    'doctor_id' => $doctor_id,
                    'name' => $works[$randNumber1]['name'],
                    'type' => 'work',
                    'start_date' => $works[$randNumber1]['start_date'],
                    'end_date' => $works[$randNumber1]['end_date']
                ]);
            }
            else
            {
                DB::table('experiences')->insert([
                    'doctor_id' => $doctor_id,
                    'name' => $works[$randNumber1]['name'],
                    'type' => 'work',
                    'start_date' => $works[$randNumber1]['start_date'],
                ]);
            }

        }
    }
}
