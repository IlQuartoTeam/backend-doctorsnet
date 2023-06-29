<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

            $doctors_id = [1, 2, 3, 4, 5];
            foreach ($doctors_id as $doctor_id) {
                for ($i=0; $i < rand(1, 10); $i++) {
                    DB::table('reviews')->insert([
                        'doctor_id' => $doctor_id,
                        'email' => $faker->email(),
                        'name' => $faker->name(),
                        'rating' => rand(1,5),
                        'text' => $faker->realText()
                    ]);
                }
            }


    }
}
