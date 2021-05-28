<?php

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::insert([
            ['hour' => '09:00', 'status' => true],
            ['hour' => '09:30', 'status' => true],
            ['hour' => '10:00', 'status' => true],
            ['hour' => '10:30', 'status' => true],
            ['hour' => '11:00', 'status' => true],
            ['hour' => '11:30', 'status' => true],
            ['hour' => '12:30', 'status' => true],
            ['hour' => '13:00', 'status' => true],
            ['hour' => '13:30', 'status' => true],
            ['hour' => '14:00', 'status' => true],
        ]);
    }
}
