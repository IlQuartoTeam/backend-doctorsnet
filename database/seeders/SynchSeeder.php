<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;

class SynchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 1; $i < 5; $i++) {
            $doctor = Doctor::where('id', $i)->first();
        //    $doctor->subscriptions()->attach('1');
        dd($doctor->review());
            $doctor->specializations()->attach(rand(1,25));
        }
    }
}
