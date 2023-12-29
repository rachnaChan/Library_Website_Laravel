<?php

namespace Database\Seeders;

use App\Models\Rooms as ModelsRooms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class rooms extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsRooms::create([
            'title' => 'Room 01',
            'description' => 'wish to be an integral part of your life!!',
            'user_room_id' => '1'
        ]);

        ModelsRooms::create([
            'title' => 'Room 02',
            'description' => 'wish to be an integral part of your life!!',
            'user_room_id' => '1'
        ]);

        ModelsRooms::create([
            'title' => 'Room 03',
            'description' => 'wish to be an integral part of your life!!',
            'user_room_id' => '1'
        ]);

    }
}
