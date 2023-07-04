<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
            $user = User::where('id', $key + 1)->first();
            $newDoctor->slug = $user->slug;
            $newDoctor->phone = $value['phone'];
            $newDoctor->profile_image_url = $value['profile_image_url'];
            $newDoctor->address = $value['address'];
            $newDoctor->city = $value['city'];
            $newDoctor->address_lat = $value['lat'];
            $newDoctor->address_long = $value['long'];
            $specializations = config('spec_performances');
            $randSpec = array_rand($specializations);
            $spec = Specialization::where('name', $randSpec)->first();
            $newDoctor->examinations = $specializations[$randSpec];
            $newDoctor->save();
            $newDoctor->specializations()->attach($spec->id);


        }
    }
}
