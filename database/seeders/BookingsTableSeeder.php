<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    public function run()
    {
        $bookingsData = [
            [
                'id' => 1,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],
            [
                'id' => 8,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],
            [
                'id' => 9,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],
            [
                'id' => 10,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 15:00:00',
                'end_at' => '2024-06-05 16:00:00',
            ],                                                                                                                       
            [
                'id' => 11,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 16:00:00',
                'end_at' => '2024-06-05 17:00:00',
            ],
            [
                'id' => 12,
                'user_id' => 1,
                'classroom_id' => 1,
                'start_at' => '2024-06-05 17:00:00',
                'end_at' => '2024-06-05 18:00:00',           
            ],           
            [
                'id' => 13,
                'user_id' => 1,
                'classroom_id' => 2,
                'start_at' => '2024-06-06 16:00:00',
                'end_at' => '2024-06-06 18:00:00',            
            ],
            [
                'id' => 14,
                'user_id' => 1,
                'classroom_id' => 2,
                'start_at' => '2024-06-08 08:00:00',
                'end_at' => '2024-06-08 10:00:00',            
            ],
            [
                'id' => 15,
                'user_id' => 1,
                'classroom_id' => 3,
                'start_at' => '2024-06-07 21:00:00',
                'end_at' => '2024-06-07 22:00:00',            
            ],            
        ];

        Booking::insert($bookingsData);
    }
}
