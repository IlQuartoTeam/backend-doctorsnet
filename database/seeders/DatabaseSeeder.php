<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            SpecializationsSeeder::class,
            DoctorsSeeder::class,
            MessagesSeeder::class,
            ReviewsSeeder::class,
            SubscriptionsSeeder::class,
            ReviewsSeeder::class,
            SynchSeeder::class,
        ]);
    }
}
