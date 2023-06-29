<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ["name" => 'Paolo',
            'surname' => 'Rossi',
            'email' => 'paolorossi@gmail.com',
            'password' => 'PaoloRossi2023' ],
            ["name" => 'Giovanni',
            'surname' => 'Palumbo',
            'email' => 'giovannipalumbo@gmail.com',
            'password' => 'GiovanniPalumbo' ],
            ["name" => 'Francesco',
            'surname' => 'Sassi',
            'email' => 'francosassi@gmail.com',
            'password' => 'FrancoSassi2023' ],
            ["name" => 'Maria',
            'surname' => 'Rossa',
            'email' => 'mariarossa@gmail.com',
            'password' => 'PaolinaRossina2023' ],
            ["name" => 'Franco',
            'surname' => 'Ciccio',
            'email' => 'franchino@gmail.com',
            'password' => 'franchino2029' ],
        ];

        foreach ($users as $user) {
            $newUser = new User();
            $newUser->name = $user['name'];
            $newUser->surname = $user['surname'];
            $newUser->email = $user['email'];
            $newUser->password = $user['password'];
            $newUser->slug = Str::slug($newUser['name'] . '-' . $newUser['surname'] . '-' . rand(1,300));
            $newUser->save();
        }
    }
}
