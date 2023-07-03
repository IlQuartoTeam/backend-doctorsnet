<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\Doctor;
use Illuminate\Support\Carbon;

class SynchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 1; $i <= 25; $i++) {
            $doctor = Doctor::where('id', $i)->first();
            $randID = rand(1, 3);
            if ($doctor->id == 2) {
            $subscription = Subscription::where('id', $randID)->first();
            //   dd($subscription->days_duration);
            $doctor->subscriptions()->attach($randID, ['end_date' => Carbon::now()->addDays($subscription->days_duration)]);
            }
            $doctor->specializations()->attach(rand(1, 25));
        }}

}
