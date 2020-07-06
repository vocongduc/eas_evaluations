<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CriteriaDependentController extends Controller
{

    /*
     * function get data categories or criterias to checkbox ajax
     *
     * return response
     */
    public function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        if ($select == "main_point_id")
        {
            $data = DB::table('categories')->where($select, $value)->groupBy('id')->get();
        }
        else {
            $data = DB::table('criterias')->where($select, $value)->groupBy('id')->get();
        }
        return response()->json($data, 200);
    }
}
