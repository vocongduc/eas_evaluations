<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    protected $table = 'teams';
    protected $fillable = ['id', 'name', 'course_id'];
    protected $perPage = 10;


    /**
     * Get the users record associated with the team.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'team_id', 'id');
    }

    /**
     * Get the course that owns the team.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function formPermit()
    {
        return $this->belongsTo(FormPermit::class, 'team_id', 'id');
    }

    public function form(){
        return $this->belongsToMany(Form::class, TeamForm::class, 'team_id','form_id');
    }

    /**
     * Get the teamform record associated with the team.
     */
    public function teamForms() {
        return$this->hasMany(TeamForm::class, 'team_id', 'id');
    }

    /**
     * function get list Team and Search
     *
     */
    public function getListTeams($input)
    {
        $builder = Team::orderBy('name');
        if (isset($input['searchName'])) {
            $builder->where('name', 'like', '%' . $input['searchName'] . '%');
        }
        return $builder->paginate();
    }

    /**
     * Insert Team
     *
     * @param array $input
     * @return \App\Models\Team
     */
    public function insertTeam($input)
    {

        $checkInsert = Team::where('name', $input['name'])->where('course_id', $input['course_id'])->get();
        if (count($checkInsert) > 0) {
            return false;
        } else {
            return Team::create($input);
        }
    }

    /**
     * Get a Team
     *
     * @param int $id
     * @return \App\Models\Team
     */
    public function getTeam($id)
    {
        return Team::findOrFail($id);
    }

    /**
     * Update Team
     *
     * @param array $input
     * @param int $id
     * @return boolean
     */
    public function updateTeam($input, $id)
    {
        $team = Team::findOrFail($id);
        $checkUpdate = Team::where('name', $input['name'])->where('course_id', $input['course_id'])->get();
        if (count($checkUpdate) > 0) {
            return false;
        } else {
            return $team->update($input);
        }
    }

    /**
     * function delete a Team
     *
     * @param $id
     * @return boolean
     */
    public function destroyTeam($id)
    {
        $team =  Team::findOrFail($id);
        if (isset($team)) {
            $deleteTeam = $team->delete();
        }
        return isset($deleteTeam);
    }

    /**
     * function list user with team
     *
     * @param $id
     * @return \App\Models\User
     */
	public function getListUsers($id)
	{
        return User::with('team')->where('team_id', '=', $id)->get();
	}

	public function listTeams() {
	    return Team::with('course')->get();
    }
}
