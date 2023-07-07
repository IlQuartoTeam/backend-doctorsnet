<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Http;

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

            $fulladdress = $value['address'] . ', ' . $value['city'];
            $apiresponse =   Http::withoutVerifying()->get('https://maps.googleapis.com/maps/api/geocode/json?address=' . $fulladdress . '&key=AIzaSyCCEWJXvirOo4hE9JCwznihyNFBwrdxrxY');
            $responsePhp  = json_decode($apiresponse->body());
            $lat = $responsePhp->results[0]->geometry->location->lat;
            $lon = $responsePhp->results[0]->geometry->location->lng;





            $newDoctor->address_lat = $lat;
            $newDoctor->address_long = $lon;
            $specializations = config('spec_performances');
            $randSpec = array_rand($specializations);
            $spec = Specialization::where('name', $randSpec)->first();
            $newDoctor->examinations = $specializations[$randSpec];
            $newDoctor->save();
            $newDoctor->specializations()->attach($spec->id);
        }
    }
}
