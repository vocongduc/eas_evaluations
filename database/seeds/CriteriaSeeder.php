<?php

use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Criteria::insert([
            [
                'category_id'=>1,
                'name'=> 'Thành tích đạt được (達成果)',
                'point_max'=>5,
                'point_weight'=>6,
                'description'=>'description ',
            ],
            [
                'category_id'=>1,
                'name'=> 'Hoàn thành công việc theo kế hoạch (スケジュール通り達成した仕事の量)',
                'point_max'=>5,
                'point_weight'=>6,
                'description'=>'description ',
            ],
            [
                'category_id'=>1,
                'name'=> 'Tính hoàn thiện của công việc (成果物の整頓)',
                'point_max'=>5,
                'point_weight'=>5,
                'description'=>'description',
            ],
            [
                'category_id'=>2,
                'name'=> 'Yêu cầu giám sát (求める監督)',
                'point_max'=>5,
                'point_weight'=>3,
                'description'=>'description',
            ],
            [
                'category_id'=>2,
                'name'=> 'Mức tiến bộ so với mục tiêu đề ra ban đầu (初期目標からのプログレス)',
                'point_max'=>5,
                'point_weight'=>3,
                'description'=>'description',
            ],
            [
                'category_id'=>2,
                'name'=> 'Chủ động trong cải thiện công việc (パフォーマンス改善のやる気)',
                'point_max'=>5,
                'point_weight'=>3,
                'description'=>'description',
            ],
            [
                'category_id'=>3,
                'name'=> 'Java',
                'point_max'=>5,
                'point_weight'=>7,
                'description'=>'description',
            ],
            [
                'category_id'=>3,
                'name'=> 'SQL',
                'point_max'=>5,
                'point_weight'=>7,
                'description'=>'description',
            ],
            [
                'category_id'=>3,
                'name'=> 'Design (設計)',
                'point_max'=>5,
                'point_weight'=>6,
                'description'=>'description',
            ],
            [
                'category_id'=>3,
                'name'=> 'Test (試験) ',
                'point_max'=>5,
                'point_weight'=>8,
                'description'=>'description',
            ],
            [
                'category_id'=>3,
                'name'=> 'Kiến thức khác có lợi cho công việc (仕事に利用する他の知識)',
                'point_max'=>5,
                'point_weight'=>5,
                'description'=>'description',
            ],
            [
                'category_id'=>4,
                'name'=> 'Teamwork (チームワーク)',
                'point_max'=>5,
                'point_weight'=>6,
                'description'=>'description',
            ],
            [
                'category_id'=>4,
                'name'=> 'Communication (lắng nghe và truyền đạt) (コミュニケーション)',
                'point_max'=>5,
                'point_weight'=>6,
                'description'=>'description',
            ],
            [
                'category_id'=>4,
                'name'=> 'Problem solving (phân tích và phán định) (問題解決) ',
                'point_max'=>5,
                'point_weight'=>5,
                'description'=>'description',
            ],
            [
                'category_id'=>5,
                'name'=> 'Tuân thủ quy định (規則の遵守)',
                'point_max'=>5,
                'point_weight'=>5,
                'description'=>'description',
            ],
            [
                'category_id'=>5,
                'name'=> 'Kế hoạch, tổ chức và thực hiện công việc (作業の計画、編成、実施)',
                'point_max'=>5,
                'point_weight'=>4,
                'description'=>'description',
            ],
            [
                'category_id'=>5,
                'name'=> 'Nhận thức về vai trò của bản thân trong tổ chức (組織での自分のロールの認識)',
                'point_max'=>5,
                'point_weight'=>4,
                'description'=>'description',
            ],
            [
                'category_id'=>6,
                'name'=> 'Ý chí cầu tiến, tạo động lực trong công việc (前進意志、モチベーション)',
                'point_max'=>5,
                'point_weight'=>5,
                'description'=>'description',
            ],
            [
                'category_id'=>6,
                'name'=> 'Mức chủ động thực hiện chỉ thị, tạo task cho bản thân (仕事でのプロアクティブ度)',
                'point_max'=>5,
                'point_weight'=>3,
                'description'=>'description',
            ],
            [
                'category_id'=>6,
                'name'=> 'Thái độ tham gia công việc và hoạt động chung (仕事・会社活動での態度)',
                'point_max'=>5,
                'point_weight'=>3,
                'description'=>'description',
            ],
        ]);
    }
}
