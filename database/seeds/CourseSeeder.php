<?php

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Course::insert([
            [
                'name'=>'Kĩ năng mềm',
                'date_start'=> '2020-06-11',
                'date_end'=> '2020-07-10',
                'description'=> 'description '
            ],
            [
                'name'=>'PHP thuần',
                'date_start'=> '2020-06-14',
                'date_end'=> '2020-07-5',
                'description'=> 'description '
            ],
            [
                'name'=>'Sql',
                'date_start'=> '2020-06-11',
                'date_end'=> '2020-07-10',
                'description'=> 'description '
            ],
            [
                'name'=>'Test',
                'date_start'=> '2020-06-11',
                'date_end'=> '2020-07-10',
                'description'=> 'description '
            ],
        ]);
    }
}
