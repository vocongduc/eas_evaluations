<?php

use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Team::insert([
            [
                'name'=>'BackEnd (PHP)',
                'course_id'=> 1
            ],
            [
                'name'=>'FrontEnd',
                'course_id'=> 2,
            ],
            [
                'name'=>'Tester',
                'course_id'=> 4,
            ]
        ]);

    }
}
