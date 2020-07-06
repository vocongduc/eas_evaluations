<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=>'admin']);
        Role::create(['name'=>'mentor']);
        Role::create(['name'=>'member']);
        Permission::create(['name' => 'Add User']);
        Permission::create(['name' => 'Edit User']);
        Permission::create(['name' => 'Delete User']);

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'address' => 'Hà Nội',
                'phone' => '0981150897',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1997-08-15',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' => 1
            ],
            [
                'name' => 'Võ Công Đức',
                'email' => 'ducvc@gmail.com',
                'address' => 'Hà Tĩnh',
                'phone' => '0347090077',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1998-12-10',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' => 1
            ],
            [
                'name' => 'Trần Văn Linh',
                'email' => 'linhtv@gmail.com',
                'address' => 'Phú Thọ',
                'phone' => '0347090077',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1998-01-16',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' => 1
            ],
            [
                'name' => 'Phan Thành Đức',
                'email' => 'ducpt@gmail.com',
                'address' => 'Nghệ An',
                'phone' => '0347090077',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1997-12-10',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' => 1
            ],
            [
                'name' => 'Lê Xuân Tùng',
                'email' => 'tunglx@gmail.com',
                'address' => 'Hưng Yên',
                'phone' => '0347090077',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1996-12-10',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' => 2
            ],
            [
                'name' => 'Nguyễn Duy Thế',
                'email' => 'thend@gmail.com',
                'address' => 'Thái Bình',
                'phone' => '0347090077',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1998-12-10',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' => 2
            ],
            [
                'name' => 'Nguyễn Ngọc Quý',
                'email' => 'quynn@gmail.com',
                'address' => 'Hà Nội',
                'phone' => '0347090077',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1999-12-10',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' => 2
            ],
            [
                'name' => 'Phạm Thị Thảo',
                'email' => 'thaopt@gmail.com',
                'address' => 'Bắc Giang',
                'phone' => '0347090077',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1997-12-10',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' => 3
            ],
            [
                'name' => 'Trần Phương Anh',
                'email' => 'anhtp@gmail.com',
                'address' => 'Nam Định',
                'phone' => '0347090077',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1998-12-10',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' => 3
            ],
            [
                'name' => 'Bùi Quang Trung',
                'email' => 'trungbq@gmail.com',
                'address' => 'Hà Nội',
                'phone' => '0981150897',
                'image' => 'upload/man-face-clip-art-png-clip-art-thumbnail.png',
                'birth_day' => '1990-08-15',
                'password' => Hash::make('123456'),
                'guard_name'=>'web',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'team_id' =>1
            ],
        ];

        \App\Models\User::insert($users);
        $dataUsers = \App\Models\User::all();
        foreach ($dataUsers as $user){
            if ($user['id'] == 1){
                $user->assignRole('admin');
            }
            elseif($user['email'] === 'trungbq@gmail.com'){
                $user->assignRole('mentor');
            }else{
                $user->assignRole('member');
            }
        }
    }
}
