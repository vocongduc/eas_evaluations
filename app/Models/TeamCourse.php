<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamCourse extends Model
{
    protected $table = "course_team";
    protected $fillable = ['team_id', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function create($team_id, $course_id){
        TeamCourse::create([
            'team_id'=>$team_id,
            'course_id'=>$course_id,
        ]);
    }
}
