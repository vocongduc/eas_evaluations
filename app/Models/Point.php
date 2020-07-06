<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\IFTTTHandler;

class Point extends Model
{
    protected $table = 'points';
    protected $fillable = ['point','form_permit_id','criteria_id','user_id'];

    /**
     * rls formPermit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formPermit(){
        return $this->belongsTo(FormPermit::class, 'form_permit_id', 'id');
    }

    /**
     * create data
     *
     * @param $criteriaId
     * @param $point
     * @param $formPermitId
     * @param $user_id
     * @return mixed
     */
    public function createData($point , $formPermitId, $criteriaId, $user_id){
        $create = Point::create([
            'point'=>$point,
            'form_permit_id'=>$formPermitId,
            'criteria_id'=>$criteriaId,
            'user_id' => $user_id
        ]);
        return $create;
    }

}
