<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Factory as Faker;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {

        $faker = Faker::create();

        $users = [];

for ($i = 0; $i < 55; $i++) {
    $user = [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'email' => $faker->email,
        'password' => 'raffaele2023',
    ];

    $users[] = $user;
}

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
