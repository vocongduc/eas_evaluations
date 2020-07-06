<?php

use Illuminate\Database\Seeder;

class MainPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\MainPoint::insert([
           [
               'name'=>'Achievement・成果',
               'priority'=>1,
               'total_point'=>100,
           ],
            [
                'name'=>'Competencies・職能',
                'priority'=>1,
                'total_point'=>100,
            ],
            [
                'name'=>'Spirit・スピリッツ',
                'priority'=>1,
                'total_point'=>100,
            ],
        ]);
    }
}
