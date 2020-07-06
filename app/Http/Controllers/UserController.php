<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Team;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    /**
     * list users
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $roles = Role::all();

        $count = 1;
        if (isset(request()->search)){
            $search = request()->search;
            $data = new User;
            $users = $data->search(request()->search);
        }else {
            $search = '';
            $users = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->join('teams', 'teams.id', '=', 'users.team_id')
                ->select(DB::raw('users.name as user_name,
                    users.email,
                    users.image,
                    users.address,
                    users.id,
                    model_has_roles.role_id,
                    teams.name as team_name,
                    roles.name as role_name'))
                ->paginate(10);
        }

        return view('users.index', compact('users','count','search','roles'));
    }

    /**
     * display create user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $roles = Role::all();
        $teams = Team::all();
        $listCoursesUsers = Course::all();
        return view('users.add',compact('roles','teams','listCoursesUsers'));
    }

    /**
     * create users
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request){
        if (!empty($request['avatar'])) {
            $fileExtension = $request->file('avatar')->getClientOriginalExtension();
            $uploadPath = 'upload';
            $fileName =$uploadPath .'/'. time() . "_image." . $fileExtension;
            $request->file('avatar')->move($uploadPath, $fileName);
        }else{
            $fileName = 'upload/man-face-clip-art-png-clip-art-thumbnail.png';
        }

        $user = new User;
        $thisUser = $user->store($request->all(), $fileName);

        $thisUserRole = $thisUser->assignRole($request->role);
        if ($thisUserRole) {
            $user->update([
                'status' => 1,
            ]);
        }

        return redirect()->route('users.index')->with('success','Thêm mới user thành công.');
    }

    /**
     * display edit
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $user = User::find($id);
        $roles = Role::all();
        $teams = Team::all();
        $listCoursesUsers = Course::with('teams')->get();
        return view('users.edit',compact('user','roles','teams','listCoursesUsers'));
    }


    /**
     * update user
     *
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id){
        $thisUser = User::find($id);
        if (!empty($request['avatar'])) {
            $fileExtension = $request->file('avatar')->getClientOriginalExtension();
            $uploadPath = 'upload';
            $fileName =$uploadPath .'/'. time() . "_image." . $fileExtension;
            $request->file('avatar')->move($uploadPath, $fileName);
        }else{
            $fileName = $thisUser->image;
        }
        $user = new User;
        $success = $user->updateData($request->all(), $fileName, $id);


        if (!empty($request->role) && $success == true) {
            $roles = Role::all();
            foreach ($roles as $role){
                if ($thisUser->hasRole($role->id)){
                    $thisUser->removeRole($role->id);
                }
            }
            $thisUserRole = $thisUser->assignRole($request->role);
            if ($thisUserRole) {
                $user->update([
                    'status' => 1,
                ]);
            }
            return redirect()->route('users.index')->with('success','Đã cập nhật thành công cho '.$thisUser['name'] );
        }
        return redirect()->route('users.index')->with('err','Cập nhật thất bại.' );
    }

    /**
     * delete user
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        $user = User::findOrFail($id);

        $roles = Role::all();
        foreach ($roles as $role){
            if ($user->hasRole($role->id)){
                $user->removeRole($role->id);
                $user->update([
                    'status' => 0,
                ]);
            }
        }
        User::destroy($id);
        return redirect()->route('users.index')->with('success','Delete User '.$user->name.' success...');
    }
    public function listCourseAjax(Request $request) {
        $course_id = $request->get('course_id');
        $value = $request->get('value');

        $data = Team::where($course_id, $value)->get();

        return response()->json($data, 200);
    }
}
