<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditRoleRequest;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role_Has_Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    /**
     * list roles
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $roles = Role::all();
        $permissions = [];
        foreach ($roles as $keyRole => $role){
            $permissions = Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')
                ->join('roles','role_has_permissions.role_id','=','roles.id')
                ->select(DB::raw('roles.name as roleName, permissions.name as permissionName, roles.id as roleId, permissions.id as perId'))
                ->get();

        }

        $count = 1;
        return view('roles.index',compact('roles','count', 'permissions'));
    }

    /**
     * display add role
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $permissions = Permission::all();
        return view('roles.add', compact('permissions'));
    }

    /**
     * create role and assign role for user
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function store(RoleRequest $request){
        $permission_id = $request['permission'];
        $role = Role::create(['name'=>$request['name']]);
        if(is_array($permission_id)) {
            foreach ($permission_id as $id){
                $permission =Permission::find($id);
                $role->givePermissionTo($permission->id);

            }
        }
        return redirect()->route('role.index')->with('success','Thêm role thành công.');
    }

    /**
     * display edit role
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $role = Role::find($id);
        $permissions = Permission::all();

        return view('roles.edit',compact('role','permissions'));
    }

    /**
     * update role
     *
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, $id){
        $role = Role::find($id);
        $permission_id = $request->permission_id;
        unset($request['permission_id']);
        if (!isset($request['name'])){
            $request['name'] = $role->name;
        }
        $role->update($request->all());
        $permissions = Permission::all();
        foreach ($permissions as $permission){
            if ($role->hasPermissionTo($permission->id)){
                $role->revokePermissionTo($permission->id);
            }
        }
        if(is_array($permission_id)) {
            foreach ($permission_id as $id){
                $role->givePermissionTo($id);
            }
        }

        return redirect()->route('role.index')->with('success','Edit role '.$role->name.' success...');
    }

    /**
     * delete role
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        $permissions = Permission::all();
        $role = Role::findOrFail($id);

        if (isset($role)){
            foreach ($permissions as $permission) {
                if ($permission->hasRole($role->id)){
                    $permission->removeRole($role->id);
                }
            }
            Role::destroy($id);
        }
        return redirect()->route('role.index')->with('success','Delete role '.$role->name.' success...');
    }

}
