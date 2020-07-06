<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class TeamForm extends Model
{
    protected $table = 'team_forms';
    protected $fillable = ['team_id','form_id','status', 'expired_date'];
    protected $perPage = 5;

    /**
     * Get the form that owns the TeamForm.
     */
    public function form(){
        return $this->belongsTo(Form::class);
    }

    /**
     * Get the team that owns the TeamForm.
     */
    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function getListTeamForm( $searchString = null){

        if(!empty($searchString)){
            $listTeamForm = TeamForm::with('team.form')
                            ->whereHas('team', function($query) use ($searchString) {
                                $query->where('name','like', '%'.$searchString . '%');
                            })
                            ->orWhereHas('form', function($query) use ($searchString) {
                                $query->where('name','like', '%'.$searchString . '%');
                            })->paginate();
        }else{
            $listTeamForm = TeamForm::with(['team','form'])->paginate();
        }

       return $listTeamForm;

    }

    public function insertTeamForm($input)
    {
        $check = TeamForm::where('team_id', $input['team_id'])->where('form_id', $input['form_id'])->get();
        if (count($check) > 0) {
            return false;
        } else {
            $input['status'] = 1;
            return TeamForm::create($input);
        }

    }

    public function updateTeamForm($input, $id)
    {

        $teamForm = TeamForm::findOrFail($id)->where('team_id', $input['team_id'])->where('form_id', $input['form_id'])->get();
        if (count($teamForm) > 0) {
            return false;
        } else {
            $input['status'] = 1;
            return $teamForm->update($input);
        }
    }

    public function getTeamForm($id)
    {
        return TeamForm::with(['form', 'team'])->findOrFail($id);
    }

    public function destroyTeamForm($id)
    {
        $teamForm =  TeamForm::findOrFail($id);
        if (isset($teamForm)) {
            $deleteTeamForm = $teamForm->delete();
        }
        return isset($deleteTeamForm);
    }

    public function getListTeamForms($id) {
        return TeamForm::with(['form', 'team'])->where('team_id', $id)->get();
    }
}
