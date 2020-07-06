<?php

namespace App\Http\Controllers;


use App\Models\MainPointUserFormPermit;
use http\Client\Response;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    protected $mainUserForm;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MainPointUserFormPermit $mainUserForm)
    {
        $this->mainUserForm = $mainUserForm;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Get Data MainPoint FormPerMit
     *
     *  @return \Illuminate\Http\Response
     */
    public function getPoint() {
        $thisUser = auth()->user();
        $array = [];
        if ($thisUser->hasRole(['member'])) {
           $array[] = $this->mainUserForm->getListPointToUsers($thisUser->id);
           if (!empty($array)) {
               return response()->json($array, 200);
           } else {
               return true;
           }
        }
    }

    /**
     * Get Data MainPoint FormPerMit
     *
     *  @return \Illuminate\Http\Response
     */
    public function FlowChartAdmin(Request $request) {
        $form_id = $request->get('charForm');
        $user_id = $request->get('charUser');
        $data = $this->mainUserForm->getFormToAdminChart($form_id, $user_id);
        return response()->json($data, 200);
    }
}
