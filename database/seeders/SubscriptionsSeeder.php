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
            'name' => '1 day',
            'price' => 2.99,
            'days_duration' => 1
        ]);
        DB::table('subscriptions')->insert([
            'name' => '3 day',
            'price' => 5.99,
            'days_duration' => 3
        ]);
        DB::table('subscriptions')->insert([
            'name' => '6 day',
            'price' => 9.99,
            'days_duration' => 6
        ]);
    }
}
