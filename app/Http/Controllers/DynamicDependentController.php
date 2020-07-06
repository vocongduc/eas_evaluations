<?php

namespace App\Http\Controllers;

use App\Models\TeamForm;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Spatie\Permission\Models\Role;

class DynamicDependentController extends Controller
{
    public function fetch(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        if ($select == "course_id")
        {
            $data = DB::table('teams')->where($select, $value)->groupBy('id')->get();
        }
        elseif ($select == "team_id") {
            $data = DB::table('users')->where($select, $value)->groupBy('id')->get();
        }else {
            $users = User::with('team')->where('id', $value)->first();
            $teamform = TeamForm::with(['team.form'])->where('team_id', $users->team_id)->get();
            $data = [];
            foreach ($teamform as $item) {
                $data[] = $item->form;
            }
        }

        return response()->json($data, 200);
    }

    public function fetchUser(Request $request) {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = Role::with('users')->where('id', $value)->get();
        return response()->json($data, 200);
    }
}
