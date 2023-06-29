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
        $newMessage = new Message();
        $newMessage->doctor_id = 1;
        $newMessage->text = $faker->paragraph();
        $newMessage->email = $faker->email();
        $newMessage->fullname = $faker->name();
        $newMessage->ip = $faker->ipv4();
        $newMessage->prefered_date = $faker->date('Y-m-d');
        $newMessage->save();
    }
}
