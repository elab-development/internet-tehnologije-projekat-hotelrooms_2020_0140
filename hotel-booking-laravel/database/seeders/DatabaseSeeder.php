<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Hotel::truncate();
        Room::truncate();
        Reservation::truncate();

        Hotel::factory(10)->has(Room::factory(50))->create();

        $guest1 = User::factory()->create();
        $guest2 = User::factory()->create();
        $guest3 = User::factory()->create();

        $room1 = Room::factory()->create([
            'hotel_id' => 1,
        ]);
        $room2 = Room::factory()->create([
            'hotel_id' => 2,
        ]);
        $room3 = Room::factory()->create([
            'hotel_id' => 3,
        ]);

        Reservation::factory()->create([
            'user_id' => $guest1->id,
            'room_id' => $room1->id,
        ]);
        Reservation::factory()->create([
            'user_id' => $guest2->id,
            'room_id' => $room2->id,
        ]);
        Reservation::factory()->create([
            'user_id' => $guest3->id,
            'room_id' => $room3->id,
        ]);
    }
}
