<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormCriteria extends Model
{
    protected $table = 'form_criterias';
    protected $fillable = ['id', 'form_id', 'criteria_id'];

    public function criteria(){
        return $this->belongsTo(Criteria::class);
    }

    public function form(){
        return $this->belongsTo(Form::class);
    }

    public function getListCriteriasFom($id) {
        return FormCriteria::where('form_id', '=', $id)->get();
    }
}
