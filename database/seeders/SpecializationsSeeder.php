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
    'Allergologia e immunologia clinica',
    'Anatomia patologica',
    'Anestesia e rianimazione',
    'Angiologia',
    'Audiologia e foniatria',
    'Chirurgia generale',
    'Chirurgia maxillo-facciale',
    'Chirurgia pediatrica',
    'Chirurgia plastica ricostruttiva ed estetica',
    'Chirurgia toracica',
    'Chirurgia vascolare',
    'Dermatologia e venereologia',
    'Ematologia',
    'Endocrinologia e malattie del metabolismo',
    'Gastroenterologia',
    'Genetica medica',
    'Geriatria',
    'Igiene e medicina preventiva',
    'Malattie dell\'apparato respiratorio',
    'Malattie infettive',
    'Medicina dello sport',
    'Medicina del lavoro',
    'Medicina fisica e riabilitazione',
    'Medicina generale (Medico di famiglia)',
    'Medicina interna',
    'Medicina legale',
    'Medicina nucleare',
    'Medicina termale',
    'Microbiologia e virologia',
    'Nefrologia',
    'Neonatologia',
    'Neurochirurgia',
    'Neurologia',
    'Neuroradiologia',
    'Oftalmologia',
    'Oncologia medica',
    'Oncologia radioterapica',
    'Ortopedia e traumatologia',
    'Ostetricia e ginecologia',
    'Otorinolaringoiatria',
    'Pediatria',
    'Psichiatria',
    'Radiodiagnostica',
    'Radioterapia',
    'Reumatologia',
    'Scienza dell\'alimentazione',
    'Urologia',
];

foreach ($specializations as $specialization) {
            $new_specialization = new Specialization();
            $new_specialization->name = $specialization;
            $new_specialization->slug = Str::slug($new_specialization->name, '-');
            $new_specialization->save();

        }

    }
}
