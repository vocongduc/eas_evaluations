<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class Permission extends Model
{
    use HasRoles;

    /**
     * search permission
     *
     * @param $name
     * @return mixed
     */
    public function search($name){
        $permission = Permission::where('name','like',"%{$name}%")->paginate(10);
        return $permission;
    }

    /**
     * update permission
     *
     * @param $name
     * @param $id
     * @return mixed
     */
    public function updatePermission($name, $id){
        $upload = Permission::where('id',$id)->update([
            'name'=>$name,
            'guard_name'=>'web'
        ]);
        return $upload;
    }
}
