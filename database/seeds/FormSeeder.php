<?php

use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Form::insert([
            [
                'name'=>'FRESHER EVALUATION',
                'description'=> ' descriptions',
            ],
            [
                'name'=>'FRESHER DOUBLE20',
                'description'=> ' descriptions',
            ]
        ]);
    }
}
