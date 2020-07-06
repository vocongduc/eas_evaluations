<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainPointUserFormPermit extends Model
{
    protected $table = 'main_point_user_form_permits';
    protected $fillable = ['total_point', 'user_id', 'form_id', 'evaluate_user_id', 'main_point_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function formPermit(){
        return $this->belongsTo(FormPermit::class, 'form_id', 'form_id');
    }

    /**
     * function get list main Point To User in FormPermit
     *
     * @param int $id
     * @return App\Models\MainPointUserFormPermit
     */
    public function getListPointToUsers($id)
    {
        $listFormToUser = MainPointUserFormPermit::with(['formPermit.user'])->where('user_id', $id)->get();

        $listIdForm = [];
        foreach ($listFormToUser as $mainPermit) {
            $listIdForm[] = $mainPermit['form_id'];
        }
        $maxFormId = max($listIdForm);
        $data = MainPointUserFormPermit::with(['formPermit.user'])->where('form_id', $maxFormId)->where('user_id', $id)->get();
        $listArray = [];
        foreach ($data as $item) {
            $user = User::findOrFail($item->evaluate_user_id);
            $listArray['form_name'] = Form::findOrFail($item->form_id)->name;
            $listArray['user_name'] = User::findOrFail($item->user_id)->name;
            $listArray['main_point_id'][] = MainPoint::findOrFail($item->main_point_id)->name;
            if ($user->hasRole(['mentor'])) {
                $listArray['mentor'][$item->evaluate_user_id]['name'] = 'mentor';
                $listArray['mentor'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
            }
            if ($user->hasRole(['admin'])) {
                $listArray['admin'][$item->evaluate_user_id]['name'] = 'admin';
                $listArray['admin'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
            }
            if ($user->hasRole(['member'])) {
                if ($item->user_id == $item->evaluate_user_id) {
                    $listArray['member']['me'][$item->evaluate_user_id]['name']  = 'Fresher';
                    $listArray['member']['me'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
                }
                if (User::where('id', $item->evaluate_user_id)->get('team_id') != User::where('id', $item->user_id )->get('team_id')) {
                    $listArray['member']['cross'][$item->evaluate_user_id]['name']  = 'cross';
                    $listArray['member']['cross'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
                }
                if ($item->user_id != $item->evaluate_user_id && User::where('id', $item->evaluate_user_id)->get('team_id') == User::where('id', $item->user_id )->get('team_id')) {
                    $listArray['member']['team'][$item->evaluate_user_id]['name']  = 'team';
                    $listArray['member']['team'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
                }
            }
        }
        if (isset($listArray['mentor'])) {
            $chartUser = [];
            foreach ($listArray['mentor'] as $memtor) {

                $chartUser[] = $memtor['total_point'];
            }
            $acc = array_shift($chartUser);

            foreach ($chartUser as $val) {
                foreach ($val as $key => $val) {
                    $acc[$key] += $val;
                    $acc[$key] =  $acc[$key]/count($listArray['mentor']);
                }
            }
            $listArray['mentor'][$item->evaluate_user_id]['sum_point'][] = $acc;
        }
        if (isset($listArray['admin'])) {
            $chartUser = [];
            foreach ($listArray['admin'] as $admin) {
                $chartUser[] = $admin['total_point'];
            }
            $acc = array_shift($chartUser);
            foreach ($chartUser as $val) {
                foreach ($val as $key => $val) {
                    $acc[$key] += $val;
                    $acc[$key] =  $acc[$key]/count($listArray['mentor']);
                }
            }
            $listArray['admin'][$item->evaluate_user_id]['sum_point'][] = $acc;
        }
        if (isset($listArray['member']['team'])) {
            $chartUser = [];
            foreach ($listArray['member']['team'] as $member) {
                if (isset($member['name']) && $member['name'] == 'team') {
                    $chartUser[] = $member['total_point'];
                }
            }
            $acc = array_shift($chartUser);
            foreach ($chartUser as $val) {
                foreach ($val as $key => $val) {
                    $acc[$key] += $val;
                    $acc[$key] =  $acc[$key]/count($listArray['member']['team']);
                }
            }
            $listArray['member']['team'][$item->evaluate_user_id]['sum_point'][] = $acc;
        }
        if (isset($listArray['member']['cross']) && count($listArray['member']['cross']) > 0) {
            $chartUser = [];
            foreach ($listArray['member']['cross'] as $member) {
                if (isset($member['name']) && $member['name'] == 'cross') {
                    $chartUser[] = $member['total_point'];
                }
            }
            $acc = array_shift($chartUser);
            foreach ($chartUser as $val) {
                foreach ($val as $key => $val) {
                    $acc[$key] += $val;
                    $acc[$key] =  $acc[$key]/count($listArray['member']['cross']);
                }
            }
            $listArray['member']['cross'][$item->evaluate_user_id]['sum_point'][] = $acc;
        }
        return $listArray;
    }


    /**
     * function get list main Point To User in FormPermit
     *
     * @param int $form_id
     * @param int $user_id
     * @return App\Models\MainPointUserFormPermit
     */
    public function getFormToAdminChart($form_id, $user_id) {
        $mains = MainPointUserFormPermit::where('user_id', $user_id)->where('form_id', $form_id)->orderBy('form_id', 'DESC')->get();
        $listArray = [];
        foreach ($mains as $item) {
            $user = User::findOrFail($item->evaluate_user_id);
            $listArray['form_name'] = Form::findOrFail($item->form_id)->name;
            $listArray['user_name'] = User::findOrFail($item->user_id)->name;
            $listArray['main_point_id'][] = MainPoint::findOrFail($item->main_point_id)->name;
            if ($user->hasRole(['mentor'])) {
                $listArray['mentor'][$item->evaluate_user_id]['name'] = 'mentor';
                $listArray['mentor'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
            }
            if ($user->hasRole(['admin'])) {
                $listArray['admin'][$item->evaluate_user_id]['name'] = 'admin';
                $listArray['admin'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
            }
            if ($user->hasRole(['member'])) {
                if ($item->user_id == $item->evaluate_user_id) {
                    $listArray['member']['me'][$item->evaluate_user_id]['name']  = 'Fresher';
                    $listArray['member']['me'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
                }
                if (User::where('id', $item->evaluate_user_id)->get('team_id') != User::where('id', $item->user_id )->get('team_id')) {
                    $listArray['member']['cross'][$item->evaluate_user_id]['name']  = 'cross';
                    $listArray['member']['cross'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
                }
                if ($item->user_id != $item->evaluate_user_id && User::where('id', $item->evaluate_user_id)->get('team_id') == User::where('id', $item->user_id )->get('team_id')) {
                    $listArray['member']['team'][$item->evaluate_user_id]['name']  = 'team';
                    $listArray['member']['team'][$item->evaluate_user_id]['total_point'][] = $item->total_point;
                }
            }
        }
        if (isset($listArray['mentor'])) {
            $chartUser = [];
            foreach ($listArray['mentor'] as $memtor) {

                $chartUser[] = $memtor['total_point'];
            }
            $acc = array_shift($chartUser);

            foreach ($chartUser as $val) {
                foreach ($val as $key => $val) {
                    $acc[$key] += $val;
                    $acc[$key] =  $acc[$key]/count($listArray['mentor']);
                }
            }
            $listArray['mentor'][$item->evaluate_user_id]['sum_point'][] = $acc;
        }
        if (isset($listArray['admin'])) {
            $chartUser = [];
            foreach ($listArray['admin'] as $admin) {
                $chartUser[] = $admin['total_point'];
            }
            $acc = array_shift($chartUser);

            foreach ($chartUser as $val) {
                foreach ($val as $key => $val) {
                    $acc[$key] += $val;
                    $acc[$key] =  $acc[$key]/count($listArray['mentor']);
                }
            }
            $listArray['admin'][$item->evaluate_user_id]['sum_point'][] = $acc;
        }
        if (isset($listArray['member']['team'])) {
            $chartUser = [];
            foreach ($listArray['member']['team'] as $member) {
                if (isset($member['name']) && $member['name'] == 'team') {
                    $chartUser[] = $member['total_point'];
                }
            }
            $acc = array_shift($chartUser);
            foreach ($chartUser as $val) {
                foreach ($val as $key => $val) {
                    $acc[$key] += $val;
                    $acc[$key] =  $acc[$key]/count($listArray['member']['team']);
                }
            }
            $listArray['member']['team'][$item->evaluate_user_id]['sum_point'][] = $acc;
        }
        if (isset($listArray['member']['cross']) && count($listArray['member']['cross']) > 0) {
            $chartUser = [];
            foreach ($listArray['member']['cross'] as $member) {
                if (isset($member['name']) && $member['name'] == 'cross') {
                    $chartUser[] = $member['total_point'];
                }
            }
            $acc = array_shift($chartUser);
            foreach ($chartUser as $val) {
                foreach ($val as $key => $val) {
                    $acc[$key] += $val;
                    $acc[$key] =  $acc[$key]/count($listArray['member']['cross']);
                }
            }
            $listArray['member']['cross'][$item->evaluate_user_id]['sum_point'][] = $acc;
        }
        return $listArray;
    }
}
