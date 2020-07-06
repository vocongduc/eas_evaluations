<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\MainPoint;
use App\Models\FormPermit;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    /**
     * display list evaluations
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $thisUser = auth()->user();
        $forms = Form::all();
        if (isset(request()->search)){
            $search = request()->search;
            $name = request()->search;
            $allUser = User::with('formPermit')->where('name','like',"%{$name}%")->get();

        }else {
            $search = '';
            $allUser = User::with('formPermit')->get();
        }
        $users = [];
        if ($thisUser->hasRole(['member'])) {
            foreach ($allUser as $user) {
                foreach ($user['formPermit'] as $key => $formPermit) {
                    if ($formPermit['evaluate_user_id'] == $thisUser['id']) {
                        $users[$user->id]['formPermit'][] = $formPermit;
                        $users[$user->id]['name'] = $user->name;
                        $users[$user->id]['id'] = $user->id;
                    }
                    if ($formPermit['evaluate_user_id'] == null && $formPermit['user_id'] == $thisUser['id'] ){
                        $users[$user->id]['formPermit'][] = $formPermit;
                        $users[$user->id]['name'] = $user->name;
                        $users[$user->id]['id'] = $user->id;
                    }
                }
            }
        }

        if ($thisUser->hasAnyRole(['admin','mentor'])) {
            foreach ($allUser as $user) {
                foreach ($user['formPermit'] as $formPermit) {
                    if ($user->hasRole('member') && $formPermit['evaluate_user_id'] == $thisUser['id']) {
                        $users[$user->id]['formPermit'][] = $formPermit;
                        $users[$user->id]['name'] = $user->name;
                        $users[$user->id]['id'] = $user->id;
                    }
                }
            }
        }
        $count = 1;
//        dd($users);
         return view('evaluations.index',compact('users','forms','search','count'));
    }

    /**
     * evaluate a user
     *
     * @param $userId
     * @param $formId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function evaluate($userId, $formId){
        $user = User::with('formPermit')->where('id',$userId)->first();
        $thisForm = '';
        $mainPoints = [];
        $formPermitIds = [];
        $evaUserIds = [];
        $forms = Form::with(['criteria.category.mainPoint'])->get();
        foreach ($forms as $form) {
            foreach ($user['formPermit'] as $data){
                if ($form->id == $data->form_id && $data->form_id == $formId) {
                    $thisForm = $form;
                    $formPermitIds[$data['id']] = $data['id'];
                    if ($data['user_id'] == $userId && $data['evaluate_user_id'] != null){
                        $evaUserIds[] = $data['evaluate_user_id'];
                    }
                }
            }
        }

        $points = Point::with('formPermit')->whereIn('form_permit_id', $formPermitIds)->get();

        $evaUsers = [];
        $tmpEvaUsers = [];
        $tmpEvaMentors = [];
        foreach ($evaUserIds as $evaUserId){
            $evaUsers[] = User::find($evaUserId);
        }
        foreach ($evaUsers as $evaUser){
            if ($evaUser->hasRole('member')){
                $tmpEvaUsers[] = $evaUser['id'];
            }
            if ($evaUser->hasRole('mentor')){
                $tmpEvaMentors[] = $evaUser['id'];
            }
        }

        $teamPoints = Point::with('formPermit')
            ->whereIn('form_permit_id', $formPermitIds)
            ->whereIn('user_id', $tmpEvaUsers)
            ->get();

        $mentorPoints = Point::with('formPermit')
            ->whereIn('form_permit_id', $formPermitIds)
            ->whereIn('user_id', $tmpEvaMentors)
            ->get();

        if (!empty($thisForm)) {
            $dataPoint = [];
            $dataTeamPoint = [];
            $dataMentorPoint = [];
            foreach ($thisForm->criteria as $criterion) {
                if (!empty($criterion)) {
                    //mentor
                    foreach ($mentorPoints as $mentorPoint){
                        if ($criterion['id'] == $mentorPoint['criteria_id'] && !empty($mentorPoint)){
                            $dataMentorPoint[$criterion['id']][$mentorPoint['id']] = $mentorPoint['point'];
                        }
                    }
                    if (!empty($dataMentorPoint)){
                        $countData = $dataMentorPoint[$criterion['id']];
                        foreach ($dataMentorPoint as $value){
                            $criterion['total_mentor_point'] = array_sum($value)/count($countData)*$criterion->point_weight;
                            $criterion['mentor_point'] = array_sum($value)/count($countData);
                        }
                    }else{
                        $criterion['mentor_point'] = '';
                    }

                    //team

                    foreach ($teamPoints as $teamPoint){
                        if ($criterion['id'] == $teamPoint['criteria_id'] && !empty($teamPoint)){
                            $dataTeamPoint[$criterion['id']][$teamPoint['id']] = $teamPoint['point'];
                        }
                    }
                    if (!empty($dataTeamPoint)){
                        $countData = $dataTeamPoint[$criterion['id']];
                        foreach ($dataTeamPoint as $value){
                            $criterion['total_team_point'] = array_sum($value)/count($countData)*$criterion->point_weight;
                            $criterion['team_point'] = array_sum($value)/count($countData);
                        }
                    }else{
                        $criterion['team_point'] = '';
                    }
                    foreach ($points as $point){
                        $userData = User::find($point['user_id']);
                        if ($criterion['id'] == $point['criteria_id'] && intval($userId) ==  $point['user_id']){
                            $dataPoint[$point['id']]['point'] = $point['point'];
                            $dataPoint[$point['id']]['cri_id'] = $point['criteria_id'];
                            if ($userData->hasRole('member')) {
                                $dataPoint[$point['id']]['user_role'] = 'member';
                            }
                            if ($userData->hasRole('mentor')) {
                                $dataPoint[$point['id']]['user_role'] = 'mentor';
                            }
                            if ($userData->hasRole('admin')) {
                                $dataPoint[$point['id']]['user_role'] = 'admin';
                            }
                        }

                        if ($criterion['id'] == $point['criteria_id']  && $userData->hasAnyRole(['admin','mentor'])){
                            $dataPoint[$point['id']]['point'] = $point['point'];
                            $dataPoint[$point['id']]['cri_id'] = $point['criteria_id'];
                            if ($userData->hasRole('member')) {
                                $dataPoint[$point['id']]['user_role'] = 'member';
                            }
                            if ($userData->hasRole('mentor')) {
                                $dataPoint[$point['id']]['user_role'] = 'mentor';
                            }
                            if ($userData->hasRole('admin')) {
                                $dataPoint[$point['id']]['user_role'] = 'admin';
                            }
                        }
                    }
                    $tmpData = [];
                    foreach ($dataPoint as $pointC){
                        if ($pointC['cri_id'] == $criterion['id'] ){
                            $tmpData[] = $pointC;
                        }
                    }

                    $criterion['point_data'] = $tmpData;

                    $mainPoints[$criterion->category->mainPoint->id]['name'] = $criterion->category->mainPoint->name;
                    $mainPoints[$criterion->category->mainPoint->id]['categories'][$criterion->category->id]['name'] = $criterion->category->name;
                    $mainPoints[$criterion->category->mainPoint->id]['categories'][$criterion->category->id]['criterias'][$criterion->id] = $criterion;
                    $mainPoints[$criterion->category->mainPoint->id]['point_weight'] = $criterion->point_weight;
                    $mainPoints[$criterion->category->mainPoint->id]['point_max'] = $criterion->point_max;
                    $mainPoints[$criterion->category->mainPoint->id]['total_point_mainPoint'] = $criterion->category->mainPoint->total_point;

                }
            }
        }else{
            return redirect()->route('evaluations.index')->with('err','Cảnh báo: Dữ liệu đầu vào lỗi.');
        }
        $form_id = $formId;
        $user_id = $userId;

        return view('evaluations.evaluate',compact('user','mainPoints','form_id','user_id'));
    }

    /**
     * evaluate form
     *
     * @param Request $request
     * @param $userId
     * @param $formId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEvaluate(Request $request, $userId, $formId){
        $userA = User::with('formPermit')->where('id', $userId)->first();
        $dataPost = [];
        $status = false;
        $formPermitId = '';
        $user = [];
        if (auth()->user()->hasRole('admin')){
            $dataPost = $request->adminEvaluate;
            $user = $this->getUser($userId);
        }
        if (auth()->user()->hasRole('mentor')){
            $dataPost = $request->mentorEvaluate;
            $user = $this->getUser($userId);
        }
        if (auth()->user()->hasRole('member')){
            $dataPost = $request->memberEvaluate;
            foreach ($userA['formPermit'] as $formPermit ){
                if ($formPermit['evaluate_user_id'] == null && $formPermit['user_id'] == auth()->user()->id){
                    $user = User::with(['formPermit' => function ($q) {
                        $q->where('evaluate_user_id', '=', null);
                    }])->where('id', $userId)->first();
                }

                if ($formPermit['evaluate_user_id'] == auth()->user()->id && $formPermit['user_id'] != auth()->user()->id){
                    $user = $this->getUser($userId);
                }
            }

        }

        foreach ($user['formPermit'] as $formPermit){
            if ($formPermit['form_id'] == $formId){
                foreach ($dataPost as $criteriaId => $point) {
                    $createPoint = new Point;
                    $createPoint->createData($point, $formPermit['id'], $criteriaId, auth()->user()->id);
                    $status = true;
                    $formPermitId = $formPermit['id'];
                }
            }
        }

        $formPermitUpdate = new FormPermit;
        if ($status == true){
            $formPermitUpdate->changeStatus(1, $formPermitId);
        }else{
            $formPermitUpdate->changeStatus(0, $formPermitId);
        }

        $mainPointIds = explode(',',$request->mainPointId);
        $pointMains = explode(',',$request->totalPoint);

        $dataPoints =[];
        foreach ($mainPointIds as $key1=> $mainPointId){
            foreach ($pointMains as$key2=> $pointMain){
                if ($key1 == $key2){
                    $dataPoints[$mainPointId] = $pointMain;
                }
            }
        }

        foreach ($dataPoints as $mainPointId => $totalPoint){
            DB::table('main_point_user_form_permits')->insert([
                'total_point' => $totalPoint,
                'user_id' => $userId,
                'form_id' => $formId,
                'evaluate_user_id' => auth()->user()->id,
                'main_point_id' => $mainPointId,
            ]);
        }

        return redirect()->route('evaluations.index')->with('success','Đã đánh giá cho '.$userA['name']);
    }

    /**
     * get user data
     *
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getUser($userId){
        $user = User::with(['formPermit' => function ($q) {
            $q->where('evaluate_user_id', auth()->user()->id);
        }])->where('id', $userId)->first();

        return $user;
    }

    /**
     * detail point user
     *
     * @param $userId
     * @param $formId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function detail($userId, $formId){
        $user = User::with('formPermit')->where('id',$userId)->first();
        $thisForm = '';
        $mainPoints = [];
        $formPermitIds = [];
        $evaUserIds = [];
        $forms = Form::with(['criteria.category.mainPoint'])->get();
        foreach ($forms as $form) {
            foreach ($user['formPermit'] as $data){
                if ($form->id == $data->form_id && $data->form_id == $formId) {
                    $thisForm = $form;
                    $formPermitIds[$data['id']] = $data['id'];
                    if ($data['user_id'] == $userId && $data['evaluate_user_id'] != null){
                        $evaUserIds[] = $data['evaluate_user_id'];
                    }
                }
            }
        }

        $points = Point::with('formPermit')->whereIn('form_permit_id', $formPermitIds)->get();

        $evaUsers = [];
        $tmpEvaUsers = [];
        $tmpEvaMentors = [];
        foreach ($evaUserIds as $evaUserId){
            $evaUsers[] = User::find($evaUserId);
        }
        foreach ($evaUsers as $evaUser){
            if ($evaUser->hasRole('member')){
                $tmpEvaUsers[] = $evaUser['id'];
            }
            if ($evaUser->hasRole('mentor')){
                $tmpEvaMentors[] = $evaUser['id'];
            }
        }

        $teamPoints = Point::with('formPermit')
            ->whereIn('form_permit_id', $formPermitIds)
            ->whereIn('user_id', $tmpEvaUsers)
            ->get();

        $mentorPoints = Point::with('formPermit')
            ->whereIn('form_permit_id', $formPermitIds)
            ->whereIn('user_id', $tmpEvaMentors)
            ->get();

        if (!empty($thisForm)) {
            $dataPoint = [];
            $dataTeamPoint = [];
            $dataMentorPoint = [];
            foreach ($thisForm->criteria as $criterion) {
                if (!empty($criterion)) {
                    //mentor
                    foreach ($mentorPoints as $mentorPoint){
                        if ($criterion['id'] == $mentorPoint['criteria_id'] && !empty($mentorPoint)){
                            $dataMentorPoint[$criterion['id']][$mentorPoint['id']] = $mentorPoint['point'];
                        }
                    }
                    if (!empty($dataMentorPoint)){
                        $countData = $dataMentorPoint[$criterion['id']];
                        foreach ($dataMentorPoint as $value){
                            $criterion['total_mentor_point'] = array_sum($value)/count($countData)*$criterion->point_weight;
                            $criterion['mentor_point'] = array_sum($value)/count($countData);
                        }
                    }else{
                        $criterion['mentor_point'] = '';
                    }

                    //team
                    foreach ($teamPoints as $teamPoint){
                        if ($criterion['id'] == $teamPoint['criteria_id'] && !empty($teamPoint)){
                            $dataTeamPoint[$criterion['id']][$teamPoint['id']] = $teamPoint['point'];
                        }
                    }
                    if (!empty($dataTeamPoint)){
                        $countData = $dataTeamPoint[$criterion['id']];
                        foreach ($dataTeamPoint as $value){
                            $criterion['total_team_point'] = array_sum($value)/count($countData)*$criterion->point_weight;
                            $criterion['team_point'] = array_sum($value)/count($countData);
                        }
                    }else{
                        $criterion['team_point'] = '';
                    }
                    foreach ($points as $point){
                        $userData = User::find($point['user_id']);
                        if ($criterion['id'] == $point['criteria_id']  && intval($userId) ==  $point['user_id']){
                            $dataPoint[$point['id']]['point'] = $point['point'];
                            $dataPoint[$point['id']]['cri_id'] = $point['criteria_id'];
                            if ($userData->hasRole('member')) {
                                $dataPoint[$point['id']]['user_role'] = 'member';
                            }
                            if ($userData->hasRole('mentor')) {
                                $dataPoint[$point['id']]['user_role'] = 'mentor';
                            }
                            if ($userData->hasRole('admin')) {
                                $dataPoint[$point['id']]['user_role'] = 'admin';
                            }
                        }

                        if ($criterion['id'] == $point['criteria_id']  && $userData->hasAnyRole(['admin','mentor'])){
                            $dataPoint[$point['id']]['point'] = $point['point'];
                            $dataPoint[$point['id']]['cri_id'] = $point['criteria_id'];
                            if ($userData->hasRole('member')) {
                                $dataPoint[$point['id']]['user_role'] = 'member';
                            }
                            if ($userData->hasRole('mentor')) {
                                $dataPoint[$point['id']]['user_role'] = 'mentor';
                            }
                            if ($userData->hasRole('admin')) {
                                $dataPoint[$point['id']]['user_role'] = 'admin';
                            }
                        }
                    }
                    $tmpData = [];
                    foreach ($dataPoint as $pointC){
                        if ($pointC['cri_id'] == $criterion['id'] )
                            $tmpData[] = $pointC;
                    }

                    $criterion['point_data'] = $tmpData;

                    $mainPoints[$criterion->category->mainPoint->id]['name'] = $criterion->category->mainPoint->name;
                    $mainPoints[$criterion->category->mainPoint->id]['categories'][$criterion->category->id]['name'] = $criterion->category->name;
                    $mainPoints[$criterion->category->mainPoint->id]['categories'][$criterion->category->id]['criterias'][$criterion->id] = $criterion;
                    $mainPoints[$criterion->category->mainPoint->id]['point_weight'] = $criterion->point_weight;
                    $mainPoints[$criterion->category->mainPoint->id]['point_max'] = $criterion->point_max;
                    $mainPoints[$criterion->category->mainPoint->id]['total_point_mainPoint'] = $criterion->category->mainPoint->total_point;

                }
            }
        }else{
            return redirect()->route('evaluations.index');
        }
        $form_id = $formId;
        $user_id = $userId;
        $thisUserFormPermit = User::with('formPermit')->where('id',$userId)->first();

        return view('evaluations.detail',compact('user','mainPoints','form_id','user_id','thisUserFormPermit'));

    }
}
