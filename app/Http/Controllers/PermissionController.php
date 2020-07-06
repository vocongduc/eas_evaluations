<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * list permission
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $count = 1;
        if (isset(request()->search)){
            $search = request()->search;
            $data = new \App\Models\Permission;
            $permissions = $data->search(request()->search);
        }else {
            $search = '';
            $permissions = \App\Models\Permission::paginate(10);
        }
        return view('permissions.index',compact('permissions','search','count'));
    }

    /**
     * display create permission
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $roles = Role::all();
        return view('permissions.add',compact('roles'));
    }

    /**
     * create permission
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function store(PermissionRequest $request){
        $permission = Permission::create(['name' => $request->name]);
        $role = $request->roles;
        $permission->syncRoles($role);

        return redirect()->route('permission.index')->with('success','Thêm permission thành công.');
    }

    /**
     * display edit permission
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $permission = \App\Models\Permission::find($id);
        return view('permissions.edit',compact('permission'));
    }

    /**
     * update permission
     *
     * @param PermissionRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PermissionRequest $request, $id){
        $permission = new \App\Models\Permission;
        $permission->updatePermission($request->name, $id);

            return redirect()->route('permission.index')->with('success','Cập nhật Permission thành công');
    }

    public function delete($id){
        $permission = \App\Models\Permission::findOrFail($id);

        if (!empty($permission)){
            $roles = Role::all();
            foreach ($roles as $role){
                if ($permission->hasRole($role->id)){
                    $permission->removeRole($role->id);

                }
            }
            \App\Models\Permission::destroy($id);
        }
        return redirect()->back()->with('success','Xóa thành công.');
    }

}
