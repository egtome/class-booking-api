<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomsTableSeeder extends Seeder
{
    public function run()
    {

        $classRoomsData = [
            [
                'id' => 1,
                'name' => 'A',
                'days_available' => '1:3',
                'hour_available_from' => '9',
                'hour_available_to' => '18',
                'slot_available_in_minutes' => '60',
                'capacity' => '10',
            ],
            [
                'id' => 2,
                'name' => 'B',
                'days_available' => '1:4:6',
                'hour_available_from' => '8',
                'hour_available_to' => '18',
                'slot_available_in_minutes' => '120',
                'capacity' => '15',             
            ],           
            [
                'id' => 3,
                'name' => 'C',
                'days_available' => '2:5:6',
                'hour_available_from' => '15',
                'hour_available_to' => '22',
                'slot_available_in_minutes' => '60',
                'capacity' => '7',             
            ],             
        ];

        Classroom::insert($classRoomsData);
    }
}
