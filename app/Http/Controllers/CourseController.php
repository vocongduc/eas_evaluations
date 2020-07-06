<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Team;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $course;
    protected $team;

    /**
     * Create a new controller instance
     *
     * @param Course $course
     * @return void
     */
    public function __construct(Course $course, Team $team)
    {
        $this->course = $course;
        $this->team = $team;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = $this->course->getListCourses($request->all());
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        try {
            $this->course->insertCourse($request->all());
            flash("Khóa học <span style='color: darkblue; font-weight: bold'>$request->name</span> đã được thêm thành công.")->success();
        } catch (\Exception $e) {
            \Log::error($e);
            flash("Thêm khóa học <span style='color: darkblue; font-weight: bold'>$request->name</span> thất bại. Vui lòng thử lại.")->error();
        }
        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $count = 1;
        $getcourse = $this->course->getCourse($id);

            return view('courses.show', compact('getcourse', 'count'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = $this->course->getCourse($id);
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CourseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, $id)
    {
        try {
            $this->course->updateCourse($request->all(), $id);
            flash("Khóa học <span style='color: darkblue; font-weight: bold'>$request->name</span> đã được cập nhật thành công.")->success();
        } catch (\Exception $e) {
            \Log::error($e);
            flash("Cập nhật Khóa học <span style='color: darkblue; font-weight: bold'>$request->name</span> thất bại. Vui lòng thử lại.")->error();
        }
        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkCourse = $this->course->destroyCourse($id);

        if ($checkCourse) {
            flash('Khóa học đã được xóa thành công.')->success();
        } else {
            flash('Xóa Khóa học thất bại. Vui lòng thử lại.')->error();
        }

        return redirect()->back();
    }
}
