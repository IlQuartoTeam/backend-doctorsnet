<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscriptions')->insert([
            'name' => 'Base - 24 ore',
            'price' => 2.99,
            'days_duration' => 1
        ]);
        DB::table('subscriptions')->insert([
            'name' => 'Premium - 72 ore',
            'price' => 5.99,
            'days_duration' => 3
        ]);
        DB::table('subscriptions')->insert([
            'name' => 'Top - 144 ore',
            'price' => 9.99,
            'days_duration' => 6
        ]);
    }
}
