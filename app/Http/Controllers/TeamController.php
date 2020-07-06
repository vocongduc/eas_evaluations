<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Course;
use App\Models\Team;
use Illuminate\Http\Request;


class TeamController extends Controller
{
    protected $team;
    protected $course;

    /**
     * Create a new controller instance
     *
     * @param Team $team
     * @param Course $course
     * @return void
     */
    public function __construct(Team $team, Course $course)
    {
        $this->team = $team;
        $this->course = $course;

    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = $this->team->getListTeams($request->all());
        $courses = $this->course->ListCourse();
        return view('teams.index', compact('teams', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = $this->course->ListCourse();
        return view('teams.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        try {
            $createTeam = $this->team->insertTeam($request->all());
            if ($createTeam == false) {
                flash("Team <span style='color: darkblue; font-weight: bold'>$request->name</span> đã tồn tại trong khóa học.")->error();
            } else {
                flash("Team <span style='color: darkblue; font-weight: bold'>$request->name</span> đã được thêm thành công.")->success();
            }
        } catch (\Exception $e) {
            \Log::error($e);
            flash("Thêm Team <span style='color: darkblue; font-weight: bold'>$request->name</span> thất bại. Vui lòng thử lại.")->error();
        }
        return redirect()->route('teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teams = $this->team->getTeam($id);
        $users = $this->team->getListUsers($id);
        return view('teams.show', compact( 'teams', 'users'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courses = $this->course->ListCourse();
        $team = $this->team->getTeam($id);
        return view('teams.edit', compact('team', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\TeamRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, $id)
    {
        try {
            $updateTeam = $this->team->updateTeam($request->all(), $id);
            if ($updateTeam == false) {
                flash("<span style='color: darkblue; font-weight: bold'>$request->name</span> đã tồn tại trong khóa học.")->error();
            } else {
                flash("<span style='color: darkblue; font-weight: bold'>$request->name</span> đã được cập nhật thành công.")->success();
            }
        } catch (\Exception $e) {
            \Log::error($e);
            flash("Cập nhật <span style='color: darkblue; font-weight: bold'>$request->name</span> thất bại. Vui lòng thử lại.")->error();
        }
        return redirect()->route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkTeam = $this->team->destroyTeam($id);

        if ($checkTeam) {
            flash('Team đã được xóa thành công.')->success();
        } else {
            flash('Xóa Team thất bại. Vui lòng thử lại.')->error();
        }

        return redirect()->back();
    }
}
