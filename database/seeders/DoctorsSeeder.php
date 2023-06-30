<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = config('doctors');
        foreach ($doctors as $key => $value) {
            $newDoctor = new Doctor;
            $newDoctor->user_id = $key + 1;
            $newDoctor->phone = $value['phone'];
            $newDoctor->profile_image_url = $value['profile_image_url'];
            $newDoctor->examinations = $value['examinations'];
            $newDoctor->address = $value['address'];
            $newDoctor->city = $value['city'];
            $newDoctor->address_lat = $value['lat'];
            $newDoctor->address_long = $value['long'];
            $newDoctor->save();

        }
    }
}
