@extends('partials.master')
@section('title')
    <title>Evaluate</title>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="head-action row mb-5">
            <div class="col-2">
                <div class="d-flex justify-content-start align-items-center ">
                    <h2 class="" style="margin-bottom:0">Mẫu đánh giá</h2>
                </div>

            </div>
            <div class="col-4">

            </div>
            <div class="col-6">
            </div>

        </div>
        <div class="row">
            <div class="col-12" style="max-width: 87%;">
                <table class="table " style="width:30%">
                    <tbody>
                    <tr>
                        <th scope="col">Họ tên</th>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Ngày tham gia</th>
                        <td>{{date('d-m-Y', strtotime($user->created_at))}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12" style="max-width: 13%;
            margin-top: 4rem;
            position: fixed;
            margin-left: 74%;
            z-index: 1038;
            top: 2rem;">
                @hasanyrole('admin|mentor')
                <a href="{{route('evaluations.index')}}">
                    <button type="button" class="btn btn-secondary ">Trở lại</button>
                </a>
                <a href="{{url('evaluations/evaluate').'/'.$user_id.'/'.$form_id}}">
                    <button type="button"
                            class="btn btn-success mr-1"
                            @foreach($thisUserFormPermit['formPermit'] as $formPermit)
                                {{$formPermit['evaluate_user_id'] == auth()->user()->id && $formPermit['status'] == 1 || $formPermit['expired_date'] < now() ? 'disabled' : ''}}
                            @endforeach>
                        Đánh giá
                    </button>
                </a>
                @endhasanyrole
            </div>
            <div class="col-12">
                <div class="row justify-content-center">
                    <form action="{{url('evaluations/evaluate').'/'.$user['id'].'/'.$form_id}}"
                          enctype="multipart/form-data" method="POST">
                        @csrf
                        <table class="table table-bordered text-center">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width:16%"> Chuyên mục</th>
                                <th scope="col" style="width:25%">Tiêu chí</th>
                                <th scope="col" style="width:7.5%">Trọng số</th>
                                <th scope="col" style="width:5%">Max Point</th>
                                <th scope="col" colspan="2" style="width:15%">Bản thân đánh giá</th>
                                @hasanyrole('admin|mentor')
                                <th scope="col" colspan="2" style="width:15%">Team đánh giá</th>
                                <th scope="col" colspan="2" style="width:15%">Mentor đánh giá</th>
                                @endhasanyrole
                                @hasrole('admin')
                                <th scope="col" colspan="2" style="width:15%">Admin đánh giá</th>
                                @endhasrole
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col" style="width:5%">Điểm</th>
                                <th scope="col" style="width:5%">Tổng điểm</th>
                                @hasanyrole('admin|mentor')
                                <th scope="col" style="width:5%">Điểm</th>
                                <th scope="col" style="width:5%">Tổng điểm</th>
                                <th scope="col" style="width:5%">Điểm</th>
                                <th scope="col" style="width:5%">Tổng điểm</th>
                                @endhasanyrole
                                @hasrole('admin')
                                <th scope="col" style="width:5%">Điểm</th>
                                <th scope="col" style="width:5%">Tổng điểm</th>
                                @endhasrole

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mainPoints as $mainPointId => $mainPoint)
                                <tr class=" table-active">
                                    <th class="text-danger">
                                        <h5>{{$mainPoint['name']}}</h5>
                                        <input type="hidden" class="main-point-id" name="main-point-id-{{$mainPointId}}"
                                               value="{{$mainPointId}}"/>
                                    </th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @hasanyrole('admin|mentor|member')
                                    <td></td>
                                    <td></td>
                                    @endhasanyrole
                                    @hasanyrole('admin|mentor')
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @endhasanyrole
                                    @hasrole('admin')
                                    <td></td>
                                    <td></td>
                                    @endhasrole
                                </tr>
                                @foreach($mainPoint['categories'] as $category)
                                    <tr>
                                        <th>{{$category['name']}}</th>
                                    @foreach($category['criterias'] as $criteria)
                                        <tr>
                                            <td></td>
                                            <td>
                                                {{$criteria->name}} <br>

                                            </td>
                                            <td class="weight-point weight-point-{{$mainPointId}}">{{$criteria->point_weight}}</td>
                                            <!-- weight point  -->
                                            <td>{{$criteria->point_max}}</td>
                                            <!-- self point  -->
                                            <td><input type="number" required min="1" max="{{$criteria->point_max}}"
                                                       class="form-control member-point member-point-{{$mainPointId}}"
                                                       name="memberEvaluate[{{$criteria->id}}]"
                                                       {{auth()->user()->hasRole('member') ? '' : 'disabled'}}
                                                       @foreach($criteria['point_data'] as $point)
                                                       @if($point['user_role'] === 'member')
                                                       value="{{$point['point']}}"
                                                       @endif
                                                       @endforeach
                                                       onkeyup="memberPoint()"
                                                disabled/></td>
                                            <td><input type="text"
                                                       class="form-control total-member-point total-member-point-{{$mainPointId}}"
                                                       disabled/>
                                            </td>
                                            @hasanyrole('admin|mentor')
                                            <!-- team  point  -->
                                            <td><input type="text"
                                                       class="form-control team-point team-point-{{$mainPointId}}"
                                                       name=""
                                                       value="{{!empty($criteria->team_point) ? substr($criteria->team_point, 0,3) : ''}}"
                                                       disabled/></td>
                                            <td><input type="text"
                                                       class="form-control total-point-team total-point-team-{{$mainPointId}} "
                                                       value="{{!empty($criteria->total_team_point) ? substr($criteria->total_team_point, 0, 4) : 0}}" disabled/></td>
                                            <!-- mentor point  -->
                                            <td><input type="number" required min="1" max="{{$criteria->point_max}}"
                                                       class="form-control mentor-point mentor-point-{{$mainPointId}}"
                                                       name="mentorEvaluate[{{$criteria->id}}]"
                                                       {{auth()->user()->hasRole('mentor') ? '' : 'disabled'}}
                                                       @foreach($criteria['point_data'] as $point)
                                                       @if($point['user_role'] === 'mentor')
                                                       value="{{!empty($criteria->mentor_point) ? substr($criteria->mentor_point,0,3) : ''}}"
                                                       @endif
                                                       @endforeach
                                                       onkeyup="mentorPoint()"
                                                disabled/></td>
                                            <td><input type="text"
                                                       class="form-control total-mentor-point total-mentor-point-{{$mainPointId}}"
                                                       @foreach($criteria['point_data'] as $point)
                                                       @if($point['user_role'] === 'admin')
                                                       value="{{!empty($criteria->total_mentor_point) ?substr($criteria->total_mentor_point,0,4) : 0}}"
                                                       @endif
                                                       @endforeach
                                                       disabled/></td>
                                            @endhasanyrole
                                            <!-- admin point  -->
                                            @hasrole('admin')
                                            <td><input type="number" required min="1" max="{{$criteria->point_max}}"
                                                       class="form-control point point-{{$mainPointId}}"
                                                       name="adminEvaluate[{{$criteria->id}}]"
                                                       @foreach($criteria['point_data'] as $point)
                                                       @if(!empty($point) && $point['user_role'] === 'admin')
                                                       value="{{$point['point']}}"
                                                       @endif
                                                       @endforeach
                                                       disabled/></td>
                                            <td><input type="text" class="form-control total-point total-point-{{$mainPointId}}" value="" disabled/>
                                            </td>
                                            @endhasrole
                                        </tr>
                                        @endforeach
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th scope="col" colspan="2" class="bg-danger text-white"> Total Point
                                            ( {{$mainPoint['name']}} )
                                        </th>
                                        <!-- weight point  -->
                                        <th class="bg-primary text-white total-main-point total-main-point-{{$mainPointId}}">0</th>
                                        <!-- self point  -->
                                        <td></td>
                                        <th></th>
                                        <th class="bg-info text-white total-criteria-point-member total-criteria-point-member-{{$mainPointId}} total-cri-point-{{$mainPointId}}">
                                            0
                                        </th>
                                        @hasanyrole('admin|mentor')
                                        <!-- team  point  -->
                                        <td></td>
                                        <th class="bg-info text-white  total-criteria-point-team-{{$mainPointId}} total-cri-point-{{$mainPointId}}">
                                            0
                                        </th>
                                        <!-- mentor point  -->
                                        <td></td>
                                        <th class="bg-info text-white total-criteria-point total-criteria-point-mentor-{{$mainPointId}} total-cri-point-{{$mainPointId}}">
                                            0
                                        </th>
                                        @endhasanyrole
                                        <!-- admin point  -->
                                        @hasrole('admin')
                                        <td></td>
                                        <th class="bg-info text-white total-criteria-point-admin total-criteria-point-{{$mainPointId}} total-cri-point-{{$mainPointId}}">
                                            0
                                        </th>
                                        @endhasrole
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end align-items-center ">
                            <input type="hidden" value="{{$user['id']}}" id="idUser">
                            <a href="{{route('evaluations.index')}}">
                                <button type="button" class="btn btn-secondary ">Trở lại</button>
                            </a>
                        </div>
                        <!--  final point table table point description -->
                        <div class="d-flex justify-content-center w-100 mb-4 mt-4">
                            <h2 class="text-center ">Tổng kết </h2>
                        </div>
                        <table class="table table-bordered table-dark">
                            <thead>
                            <tr style="height:100px; font-size:2rem;vertical-align: middle; text-align: center;line-height: 100px;">
                                <th scope="col">Final Evaluation Score</th>
                                <th scope="col" class="total-point-user"></th>
                                <th scope="col" class="point-character">C</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <th scope="row">1</th>
                                <td>S (950 ~ 1.000 Outstanding</td>
                                <td>5</td>
                                <td>B- (300 ~ 399) Need To Improve (NTI)</td>
                            </tr>
                            <tr>
                                <td></td>
                                <th scope="row">2</th>
                                <td>A (800 ~ 949) Excellent</td>
                                <td>6</td>
                                <td>C (0 ~ 299) Weak</td>
                            </tr>
                            <tr>
                                <td></td>
                                <th scope="row">3</th>
                                <td>B+ (600 ~ 799)Very Good</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <th scope="row">4</th>
                                <td>B (400 ~ 599)Good</td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{asset('js/evaluate.js')}}"></script>
@stop
