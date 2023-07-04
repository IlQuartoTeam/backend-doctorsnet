<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            for ($x = 1; $x < rand(1,6); $x++) {
                $randmessage = array_rand($messages);
                $alreadyUsed = [];
                array_push($alreadyUsed, $randmessage);
                while (in_array($randmessage, $alreadyUsed)) {
                    $randmessage = array_rand($messages);
                }
        $newMessage = new Message();
        $newMessage->doctor_id = $i;
        $newMessage->text = $messages[$randmessage]['text'];
        $newMessage->email = $messages[$randmessage]['email'];
        $newMessage->fullname = $messages[$randmessage]['fullname'];
        $newMessage->ip = $faker->ipv4();
        $newMessage->prefered_date = $faker->date('Y-m-d');
        $newMessage->save();
            }
    }}
}
