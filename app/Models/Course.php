<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = ['id', 'name', 'date_start', 'date_end', 'description'];
    protected $perPage = 10;

    /**
     * Get the team record associated with the team.
     */
    public function teams()
    {
        return $this->hasMany(Team::class, 'course_id', 'id');
    }
    /**
     * Get the team record associated with the course.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function formPermit(){
        return $this->belongsTo(FormPermit::class,'team_id');
    }
    /**
     * Get name, id in table course
     *
     * @return Colection
     */
    public function ListCourse()
    {
        return Course::orderBy('name')->pluck('name', 'id');
    }

    /**
     * function get list Courses and Search
     *
     */
    public function getListCourses($input)
    {
        $builder = Course::orderBy('name', 'asc');
        if (isset($input['searchName'])) {
            $builder->where('name', 'like', '%' . $input['searchName'] . '%');
        }
        return $builder->paginate();
    }

    /**
     * Insert Course
     *
     * @param array $input
     * @return \App\Models\Course
     */
    public function insertCourse($input)
    {
        return Course::create($input);
    }

    /**
     * Get a Course
     *
     * @param int $id
     * @return \App\Models\Course
     */
    public function getCourse($id)
    {
        return Course::with(['teams.users'])->findOrFail($id);
    }

    /**
     * Update Course
     *
     * @param array $input
     * @param int $id
     * @return boolean
     */
    public function updateCourse($input, $id)
    {
        $course = Course::findOrFail($id);
        return $course->update($input);
    }

    /**
     * function delete a coursse
     *
     * @param $id
     * @return boolean
     */
    public function destroyCourse($id)
    {
        $course =  Course::findOrFail($id);
        if (isset($course)) {
            $deleteCourse = $course->delete();
        }
        return isset($deleteCourse);
    }

    /**
     * function list team with course
     *
     * @param $id
     * @return \App\Models\Team
     */
    public function getListTeam($id) {
        return Team::with('course')->where('course_id', '=', $id)->get();

    }

    /**
     * function list team with course
     *
     * @param $id
     * @return \App\Models\Team
     */
    public function ListCourses() {
        return Course::all();

    }

}
