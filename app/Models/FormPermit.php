<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PharIo\Manifest\Email;

class FormPermit extends Model
{
    protected $table = 'form_permits';
    protected $fillable = ['form_id', 'expired_date', 'status', 'user_id', 'evaluate_user_id'];
    protected $perPage = 10;

    /**
     * rls criteria
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function criterias()
    {
        return $this->belongsToMany(Criteria::class, Point::class, 'form_permit_id', 'criteria_id');
    }

    /**
     * rls user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * rls form
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * rls points
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function point()
    {
        return $this->hasMany(Point::class, 'form_permit_id', 'id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function roles()
    {
        return $this->hasMany(Permission::class);
    }

    public function insertFormPermit($input)
    {
        return FormPermit::create($input);
    }

    /**
     * rls mainPointUsers
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function mainPointUsers(){
        return $this->hasMany(MainPointUserFormPermit::class, 'form_id', 'form_id');
    }

    /**
     * update status
     *
     * @param $status
     * @param $idFormPermit
     * @return bool
     */
    public function changeStatus($status, $idFormPermit)
    {
        FormPermit::where('id', $idFormPermit)
            ->update([
                'status' => $status
            ]);
        return true;
    }


    /**
     * get user form Permit
     *
     * @param int $id
     * @return \App\Models\FormPermit
     */
    public function getUserFormPermit($id)
    {

        return FormPermit::with('user')->where('form_id', '=', $id)->first();
    }

    public function getListFormPermit($searchForm = null)
    {
        echo $searchForm;
        if (!empty($searchForm)) {
            $builder = FormPermit::with(['user', 'form'])
                ->whereHas('user', function ($query) use ($searchForm) {
                    $query->where('name', 'like', '%' . $searchForm . '%');
                })
                ->orWhereHas('form', function ($query) use ($searchForm) {
                    $query->where('name', 'like', '%' . $searchForm . '%');
                })
                ->where('evaluate_user_id',null)
                ->paginate();
        } else {
            return FormPermit::with(['form', 'user.team.course'])->where('evaluate_user_id',null)->paginate();
        }
        return $builder;
    }

    public function getFormPermit($id)
    {
        $builder = FormPermit::with(['form', 'user.team.course'])->findOrFail($id);
        return $builder;
    }
    public function insertUserFormPermit($input, $arrayEvaluateUserID)
    {
        $check = false;
        if (!empty($arrayEvaluateUserID)){
            $input['status'] = 0;
            $listUserIdFormPermit = FormPermit::where('user_id', $input['user_id'])->first();
            if (empty($listUserIdFormPermit)) {
                FormPermit::insert([
                    'form_id' => $input['form_id'],
                    'expired_date' => $input['expired_date'],
                    'status' => $input['status'],
                    'user_id' => $input['user_id'],
                    'evaluate_user_id' => null
                ]);
                FormPermit::insert([
                    'form_id' => $input['form_id'],
                    'expired_date' => $input['expired_date'],
                    'status' => $input['status'],
                    'user_id' => $input['user_id'],
                    'evaluate_user_id' => 1
                ]);
            }
            if (!empty($arrayEvaluateUserID)) {
                foreach ($arrayEvaluateUserID as $data) {
                    FormPermit::insert([
                        'form_id' => $input['form_id'],
                        'expired_date' => $input['expired_date'],
                        'status' => $input['status'],
                        'user_id' => $input['user_id'],
                        'evaluate_user_id' => $data
                    ]);
                }
            }
            $check = true;
        }
        return $check;
    }

    public function updateFormPermit($input, $user_id, $form_id, $arrayEvaluateUserIDs){
        $input['status'] = 0;
        $formPermits = FormPermit::where('user_id',$user_id)
            ->where('form_id', $form_id)
            ->where('evaluate_user_id','<>', null)
            ->where('evaluate_user_id','<>', 1)
            ->get();

        if (!empty($formPermits) && !empty($arrayEvaluateUserIDs)) {
            foreach ($formPermits as $dataFormPermit) {
                $dataFormPermit->delete();
            }
        }
        $formPermitUser = FormPermit::where('user_id',$user_id)
            ->where('form_id', $form_id)
            ->where('evaluate_user_id', null)
            ->where('evaluate_user_id', 1)
            ->get();

        if (!empty($formPermitUser) && !empty($arrayEvaluateUserIDs)){
            foreach ($arrayEvaluateUserIDs as $data) {
                FormPermit::insert([
                    'form_id' => $input['form_id'],
                    'expired_date' => $input['expired_date'],
                    'status' => $input['status'],
                    'user_id' => $user_id,
                    'evaluate_user_id' => $data
                ]);
            }
        }

        if (empty($formPermitUser)){
           return false;
        }
        return true;
    }

    public function destroyFormPermit($id)
    {
        $formPermit = FormPermit::findOrFail($id);
        if (isset($formPermit)) {
            $deleteFormPermit = $formPermit->delete();
        }
        return isset($deleteFormPermit);
    }

    public function getPermitGetEvaluateUser($id)
    {
        return FormPermit::where('form_id', $id)->get();
    }
}
