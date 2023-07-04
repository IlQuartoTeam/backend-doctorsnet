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
    "Chirurgia pediatrica",
    "Chirurgia plastica ed estetica",
    "Chirurgia toracica",
    "Chirurgia vascolare",
    "Dermatologia e venereologia",
    "Ematologia",
    "Gastroenterologia",
    "Genetica medica",
    "Geriatria",
    "Malattie infettive",
    "Medicina dello sport",
    "Medicina del lavoro",
    "Fisioterapia",
    "Medicina generale",
    "Medicina interna",
    "Medicina legale",
    "Medicina nucleare",
    "Medicina termale",
    "Microbiologia e virologia",
    "Nefrologia",
    "Neonatologia",
    "Neurochirurgia",
    "Neurologia",
    "Neuroradiologia",
    "Oftalmologia",
    "Oncologia medica",
    "Oncologia radioterapica",
    "Ortopedia e traumatologia",
    "Ostetricia e ginecologia",
    "Otorinolaringoiatria",
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




