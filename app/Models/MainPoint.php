<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainPoint extends Model
{
    protected $table = 'main_points';
    protected $fillable = ['id','name','priority','total_point'];


    public function categories(){
        return $this->hasMany(Category::class, 'main_point_id', 'id');
    }

    /**
     * function get líst mainpoint
     *
     * @return Colection
     */
    public function getListMaintPoint()
    {
        return MainPoint::orderBy('name', 'asc')->pluck('id', 'name');
    }
}
