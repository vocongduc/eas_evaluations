<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormPermitRequest;
use App\Models\Course;
use App\Models\Form;
use App\Models\FormPermit;
use App\Models\Permission;
use App\Models\Team;
use App\Models\TeamForm;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class FormPermitController extends Controller
{

    protected $formPermit;
    protected $course;
    protected $team;
    protected $user;
    protected  $form;
    protected  $teamForm;

    public  function __construct(FormPermit $formPermit, Team $team, Course $course, User $user, Form $form, TeamForm $teamForm)
    {
        $this->formPermit = $formPermit;
        $this->teamForm = $teamForm;
        $this->team = $team;
        $this->user = $user;
        $this->course = $course;
        $this->form = $form;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searchFormPermit = '';
        $count = 1;
        $listTeams = $this->team->getListTeams(request()->all());
        $listCourses = $this->course->getListCourses(request()->all());
        $listFormPermits = $this->formPermit->getListFormPermit(request()->search_form_permit);
        $listUsers = $this->user->all();
        if (!empty(request()->search_form_permit)){
            $searchFormPermit = request()->search_form_permit;
        }
        return view('form_permits.index', compact('listTeams', 'listCourses', 'listFormPermits', 'count', 'listUsers','searchFormPermit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles =  Role::with('users')->get();
        $listCourses = Course::all();
        $users = User::all();
        return view('form_permits.create', compact('listCourses','users','roles'));
    }

    /**
     * @param FormPermitRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormPermitRequest $request)
    {
        $arrayEvaluateUserID = explode(',', $request['evaluate_user_id']);
        $thisUserId = ($request['user_id']);
        foreach ($arrayEvaluateUserID as $key=> $evaluateUserID){
            $data = FormPermit::where('evaluate_user_id', $evaluateUserID)->where('user_id', $thisUserId)->first();
            if (!empty($data)){
                unset($arrayEvaluateUserID[$key]);
            }
            if ($evaluateUserID == $request['user_id']) {
                unset($arrayEvaluateUserID[$key]);
            }
            if ($evaluateUserID == 1) {
                unset($arrayEvaluateUserID[$key]);
            }
        }
        $dataFormPermit = $this->formPermit->insertUserFormPermit($request->all(), $arrayEvaluateUserID);
        if ($dataFormPermit == true) {
            return redirect()->route('formPermit.index')->with('success', 'Phân quyền đánh giá chéo thành công');
        }
        return redirect()->route('formPermit.index')->with('error','Phân quyền  thất bại');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formPermit =  $this->formPermit->find($id);
        $user = User::where('id',$formPermit['user_id'])->first();
        $allData = FormPermit::where('user_id',$formPermit['user_id'])
            ->where('evaluate_user_id','<>', null)->get();
        foreach ($allData as $data){
            $user2 = User::where('id',$data['evaluate_user_id'])->first();
            $data['eva_name'] = $user2['name'];
            if ($user2->hasRole('mentor')){
                $data['role_name'] = '( mentor )';
            }
            if ($user2->hasRole('admin')){
                $data['role_name'] = '( admin )';
            }
        }
        return view('form_permits.detail',compact('user', 'allData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formPermits =  $this->formPermit->getFormPermit($id);
        dd($formPermits);
        $user = $this->user->getUser($formPermits->user_id);
        $teamforms = $this->teamForm->getListTeamForms($user->team_id);
        $roles =  Role::with('users')->get();
        $formUserEvalues = $this->formPermit->getPermitGetEvaluateUser($formPermits->form_id);
        $arrUserEvarluId = [];
        foreach ($formUserEvalues as $userValue) {
            $arrUserEvarluId[] = $userValue->evaluate_user_id;
        }
        $arrCriteriasForm = json_encode($arrUserEvarluId);
        $arrUserEvaluteForm = trim($arrCriteriasForm,'[]');
        return view('form_permits.edit', compact('formPermits', 'teamforms', 'roles', 'arrUserEvaluteForm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = FormPermit::find($id);
        $arrayEvaluateUserID_tmp = explode(',', $request['evaluate_user_id']);
        $thisUserId = ($request['user_id']);

       foreach ($arrayEvaluateUserID_tmp as $key=>$eva_id){
           $data = FormPermit::where('user_id', $data['user_id'])->first();

           if ( intval($eva_id) == 0 || $eva_id == 1){
               unset($arrayEvaluateUserID_tmp[$key]);
           }
           if ($eva_id == $data['user_id']) {
               unset($arrayEvaluateUserID_tmp[$key]);
           }
       }
       $arrayEvaluateUserIDs = array_unique($arrayEvaluateUserID_tmp);

        $dataUpdate = $this->formPermit->updateFormPermit($request->all(), $data['user_id'], $data['form_id'], $arrayEvaluateUserIDs);

        if($dataUpdate == true){
            return redirect()->route('formPermit.index')->with('success', 'Cập nhật phân quyền thành công');
        }else{
            return redirect()->route('formPermit.index')->with('erorr', 'Cập nhật không thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkFormPermit = $this->formPermit->destroyFormPermit($id);

        if ($checkFormPermit) {
            return redirect()->back()->with('success', 'Xóa thành công');
        } else {
            return redirect()->back()->with('error', 'Xóa thất bại');
        }


    }

    public function listTeamByCourse(Request $request) {
        $value = $request->get('value');
        $select = $request->get('select');
        $dependent = $request->get('dependent');
        if ($select == "course_id")
        {
            $data =  DB::table('courses')->where($select, $value)->groupBy('id')->get();
        }
        return response()->json($data, 200);
    }
}
