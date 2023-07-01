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

        for ($i = 1; $i <= 55; $i++) {
            $doctor = Doctor::where('id', $i)->first();
            $doctor->subscriptions()->attach(rand(1,3));
            if ($doctor->id === 7 || $doctor->id === 10 || $doctor->id === 33) {
            $doctor->specializations()->attach(rand(1,47));
            }

        }
    }
}


$recensioni = [
    ['doctor_id' => 1,
    'email' => 'francesco@gmail.com',
    'name' => 'Francesco Paoli',
    'rating' => '4',
    'text' => "Mi sono trovato molto bene con questo medico, è molto apprensivo e ci tiene al paziente!"],
];
