<?php

use Illuminate\Database\Seeder;

class TeamFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\TeamForm::insert([
            [
                'team_id'=> 1,
                'form_id'=> 1,
                'status' => 1,
                'expired_date' => '2020-07-11'
            ],
            [
                'team_id'=> 2,
                'form_id'=> 2,
                'status' => 1,
                'expired_date' => '2020-07-11'
            ]
        ]);
    }
}
