<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criterias';
    protected $fillable = ['id','category_id','name','point_max','point_weight','description'];

    public function formPermits(){
        return $this->belongsToMany(FormPermit::class, Point::class, 'form_permit_id','criteria_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function mainPoint(){
        return $this->hasOne(MainPoint::class);
    }

    public function form(){
        return $this->belongsToMany(Form::class, FormCriteria::class, 'form_id', 'criteria_id');
    }

    public function formCriteria(){
        return $this->hasMany(FormCriteria::class);
    }

    public function point(){
        return $this->belongsTo(Point::class);
    }
}
