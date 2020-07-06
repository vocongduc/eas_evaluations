<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['id', 'name','priority','main_point_id'];

    public function mainPoint(){
        return $this->belongsTo(MainPoint::class, 'main_point_id', 'id');
    }
    public function criterias(){
        return $this->hasMany('App\Models\Criteria','category_id');
    }
}
