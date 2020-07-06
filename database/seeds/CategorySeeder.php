<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::insert([
            [
                'main_point_id'=>1,
                'name'=> 'Tính hiệu quả (効果性)',
                'priority'=>1,
            ],
            [
                'main_point_id'=>1,
                'name'=> 'Mức tiến bộ (プログレッシブ)',
                'priority'=>1,
            ],[
                'main_point_id'=>2,
                'name'=> 'Kiến thức (知識)',
                'priority'=>1,
            ],
            [
                'main_point_id'=>2,
                'name'=> 'Kỹ năng (スキル)',
                'priority'=>1,
            ],
            [
                'main_point_id'=>3,
                'name'=> 'Tinh thần trách nhiệm (責任感)',
                'priority'=>1,
            ],
            [
                'main_point_id'=>3,
                'name'=> 'Tính chủ động tích cực (積極性)',
                'priority'=>1,
            ]
        ]);
    }
}
