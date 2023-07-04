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
            $toSubscribe = [1,6,12,16,21];
            $doctor = Doctor::where('id', $i)->first();
            if (in_array($i, $toSubscribe)) {
                $randID = rand(1, 3);
            $subscription = Subscription::where('id', $randID)->first();
            //   dd($subscription->days_duration);
            $doctor->subscriptions()->attach($randID, ['end_date' => Carbon::now()->addDays($subscription->days_duration)]);
            }
        }}

}
