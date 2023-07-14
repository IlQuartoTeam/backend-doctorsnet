<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Specialization;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

     $specializations= [
    "Allergologia",
    "Anatomia patologica",
    "Angiologia",
    "Chirurgia generale",
    "Chirurgia plastica",
    "Chirurgia vascolare",
    "Dermatologia",
    "Ematologia",
    "Gastroenterologia",
    "Genetica medica",
    "Geriatria",
    "Malattie infettive",
    "Medicina dello sport",
    "Medicina del lavoro",
    "Fisiatria",
    "Medicina generale",
    "Medicina legale",
    "Virologia",
    "Neonatologia",
    "Neurochirurgia",
    "Neurologia",
    "Oftalmologia",
    "Oncologia medica",
    "Oncologia",
    "Ortopedia",
    "Ginecologia",
    "Pediatria",
    "Psichiatria",
    "Radiodiagnostica",
    "Radioterapia",
    "Reumatologia",
    "Urologia",
];

foreach ($specializations as $specialization) {
            $new_specialization = new Specialization();
            $new_specialization->name = $specialization;
            $new_specialization->slug = Str::slug($new_specialization->name, '-');
            $new_specialization->save();

        }

    }
}




