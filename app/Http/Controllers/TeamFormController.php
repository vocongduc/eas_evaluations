<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamFormRequest;
use App\Models\Course;
use App\Models\Form;
use App\Models\Team;
use App\Models\TeamForm;
use Illuminate\Http\Request;
class TeamFormController extends Controller
{

    protected $teamForm;
    protected $course;

    public  function __construct(TeamForm $teamForm, Course $course)
    {
        $this->teamForm = $teamForm;
        $this->course = $course;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = '';
        $count = 1;
        $listCourses =  $this->course->ListCourses();
        $listTeamForms = $this->teamForm->getListTeamForm(request()->search_team_form);
        if (!empty(request()->search_team_form)){
            $search = request()->search_team_form;
        }
//        dd($listTeamForms);
        return  view('team_forms.index',compact('listTeamForms', 'listCourses', 'count', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  $listCourses = Course::all();
        $listForms = Form::all();
        return view('team_forms.create',compact('listCourses','listForms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamFormRequest $request)
    {
           if($this->teamForm->insertTeamForm($request->all())){
               return redirect()->route('teamForm.index')->with('success','Form được phân quyền thành công  ');
           } else {
               return redirect()->route('teamForm.index')->with('error', 'Phân quyền form thất bại');
           }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teamForm = $this->teamForm->getTeamForm($id);
        $course = $this->course->getCourse($teamForm->team->course_id);
        $form = Form::all();
        $expiredDate = TeamForm::all();
        return view('team_forms.edit', compact('teamForm','course','form', 'expiredDate'));
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
        if($this->teamForm->updateTeamForm($request->all(), $id)){
            return redirect()->route('teamForm.index')->with('success','Form được cập nhật phân quyền thành công  ');
        }else{
            return redirect()->route('teamForm.index')->with('error', 'Cập nhật Phân quyền form thất bại');
        }
        return redirect()->route('teamForm.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkTeamForm = $this->teamForm->destroyTeamForm($id);

        if ($checkTeamForm) {
            flash(' Xóa thành công.')->success();
        } else {
            flash('Xóa  thất bại. Vui lòng thử lại.')->error();
        }

        return redirect()->back();
    }
    public function listTeamAjax(Request $request) {
        $course_id = $request->get('course_id');
        $value = $request->get('value');

        $data = Team::where($course_id, $value)->get();

        return response()->json($data, 200);
    }
}
