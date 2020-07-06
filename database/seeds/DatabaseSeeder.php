<?php

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
        $this->call(CourseSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MainPointSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CriteriaSeeder::class);
        $this->call(FormSeeder::class);
        $this->call(TeamFormSeeder::class);
        $this->call(FormCriteriaSeeder::class);
        $this->call(FormPermitSeeder::class);

    }
}
