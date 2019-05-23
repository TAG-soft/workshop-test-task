<?php

use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workshops')->insert([
            ['day' => '2019-06-01', 'time' => '9AM - 12PM', 'max_guests' => 5],
            ['day' => '2019-06-01', 'time' => '12PM - 3PM', 'max_guests' => 5],
            ['day' => '2019-06-01', 'time' => '3PM - 6PM', 'max_guests' => 7],
            ['day' => '2019-06-02', 'time' => '9AM - 12PM', 'max_guests' => 5],
            ['day' => '2019-06-02', 'time' => '12PM - 3PM', 'max_guests' => 5],
            ['day' => '2019-06-02', 'time' => '3PM - 6PM', 'max_guests' => 12],
            ['day' => '2019-06-03', 'time' => '9AM - 12PM', 'max_guests' => 5],
            ['day' => '2019-06-03', 'time' => '12PM - 3PM', 'max_guests' => 7],
            ['day' => '2019-06-03', 'time' => '3PM - 6PM', 'max_guests' => 5],
        ]);
    }
}
