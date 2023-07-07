<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Message;
use Faker\Generator as Faker;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $messages = config('messages');

        for ($i = 1; $i <= 100; $i++) {
            $alreadyUsed = [];

            for ($x = 1; $x < rand(2,6); $x++) {
                $randreview = array_rand($messages);
                array_push($alreadyUsed, $randreview);
                while (in_array($randreview, $alreadyUsed)) {
                    $randreview = array_rand($messages);
                }

        $newMessage = new Message();
        $newMessage->doctor_id = $i;
        $newMessage->text = $messages[$randreview]['text'];
        $newMessage->email = $messages[$randreview]['email'];
        $newMessage->fullname = $messages[$randreview]['fullname'];
        $newMessage->ip = $faker->ipv4();
        $newMessage->prefered_date = $faker->date('Y-m-d');
        $newMessage->created_at = Carbon::today()->subDays(rand(0, 365));
        $newMessage->save();
            }
    }}
}
