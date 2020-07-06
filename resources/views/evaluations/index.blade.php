@extends('partials.master')
@section('title')
    <title>Evaluations</title>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="head-action row mb-5">
            <div class="col-2">
                <h2 class="">Quản lý đánh giá</h2>
            </div>
            <div class="col-4">
                <form action="{{route('evaluations.index')}}?searchName=" enctype="multipart/form-data" method="GET">
                    @csrf
                    <div class="input-group md-form form-sm form-2 pl-0 ">
                        <input class="form-control my-0 py-1 red-border" value="{{$search}}" type="text" name="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="input-group-text red lighten-3"
                                    type="submit" id="basic-text1">
                                <i class="fas fa-search text-grey" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if(session()->has('err'))
                <div class="alert alert-danger">
                    {{ session()->get('err') }}
                </div>
            @endif
        </div>
        <table class="table table-hover mb-5">
            <thead>
            <tr>
                <th>STT</th>
                <th class="text-left">Tên</th>
                <th class="text-left">Tiêu đề</th>
                <th>Ngày hết hạn</th>
                <th>Trạng thái</th>
                <th class="text-left">Action</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($users))
            @foreach($users as $user)
                @foreach($user['formPermit'] as $formPermit)
                    <tr >
                        <td scope="row">{{$count ++}}</td>
                        <td class="text-left">{{$user['name']}} <i
                                style="color: palevioletred">{{auth()->user()->name == $user['name'] ?' (Me)': ''}}
                        </td>
                        <td class="text-left">
                            @foreach($forms as $form)
                                {{$form['id'] == $formPermit['form_id'] ? $form['name'] : ''}}
                            @endforeach
                        </td>
                        <td>{{date('d-m-Y', strtotime($formPermit['expired_date']))}}</td>
                        <td>
                            {{$formPermit['status'] == 0 ? $formPermit['expired_date'] < now() ? 'Đã hết hạn đánh giá' : 'Đang chờ ...' : 'Đã đánh giá'}}
                        </td>
                        <td>
                            @if(auth()->user()->id == $user['id'] || auth()->user()->hasAnyRole(['admin','mentor']))
                            <a href="{{url('evaluations/detail').'/'.$user['id'].'/'.$formPermit['form_id']}}">
                                <button type="button" class="btn btn-secondary mr-1">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </a>
                            @endif
                            @hasanyrole('admin|mentor')
                            <button type="button" class="btn btn-danger FlowChart mr-1" id="FlowChart" name="FlowChart" data-toggle="modal" data-target="#chartModal">
                                <input type="hidden" class="chart_user_id chart_user_id-{{ $user['id'] }}" value="{{ $user['id'] }}">
                                <input type="hidden" class="chart_form_id chart_form_id-{{ $formPermit['form_id'] }}" value="{{ $formPermit['form_id'] }}">
                                <i class="fas fa-chart-bar"></i>
                            </button>
                            @endhasanyrole
                            <a href="{{$formPermit['status'] == 0 ? url('evaluations/evaluate').'/'.$user['id'].'/'.$formPermit['form_id'] : ''}}">
                                <button type="button"
                                        class="btn btn-success mr-1"
                                        {{$formPermit['status'] == 1 || $formPermit['expired_date'] < now() ? 'disabled' : ''}} >
                                    Đánh giá
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center text-dark"><h4>No data ...</h4></td>
                </tr>
            @endif
            </tbody>
        </table>

        <nav aria-label="Page navigation example">

        </nav>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="width:100%; max-width: 70%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Biểu Đồ Đánh Giá</h5>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="modal-body" style="width: 50%">
                        <canvas id="myAreaChart"></canvas>
                        <p id="content-chart" style="text-align: center; font-weight: bold; margin-top: 20px; color: darkblue">Biểu Đồ Đánh Giá Admin,Mentor</p>
                    </div>
                    <div class="modal-body" style="width: 50%" >
                        <canvas id="chart" ></canvas>
                        <p id="chart" style="text-align: center; font-weight: bold; margin-top: 20px; color: darkblue">Biểu Đồ Đánh Giá Cá Nhân Team, Colleague</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-chart" id="close-chart" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('inline_scripts')
    <script type="text/javascript">
        const btnCharts = document.querySelectorAll('.FlowChart')
        const btnclose = document.querySelectorAll('.close-chart')
        const charUserIds = document.querySelectorAll('.chart_user_id')
        const charFormIds = document.querySelectorAll('.chart_form_id')
        btnCharts.forEach((btnChart,index) => {
            btnChart.addEventListener('click',(e) => {
                e.preventDefault()
                const charUser = charUserIds[index].value
                const charForm = charFormIds[index].value
                const token = $("input[name='_token']").val()
                $.ajax({
                    url: "{{ route('flowChartAdmin.getall') }}",
                    method: "GET",
                    data: {charUser: charUser, charForm: charForm, _token: token},
                    success: function (result) {
                        var arrMainPoint = [];
                        var arrMainPoint = result.main_point_id;
                        var arrMainPointFilter = arrMainPoint.filter((result, index) => arrMainPoint.indexOf(result) === index);
                        var arrPointAdmin = [];
                        var arrPointMentor = [];
                        var arrPointTeam = [];
                        var arrPointCross = [];
                        var arrPointFresher = [];
                        $.each(result.admin, function (keyAdmin, ValueAdmin) {
                            $.each(ValueAdmin.sum_point, function (aKey, adminKey) {
                                $.each(adminKey, function (admin, vAdmin) {
                                    arrPointAdmin.push(vAdmin);
                                })
                            })
                        })
                        $.each(result.mentor, function (keyMenTor, ValueMentor) {
                            $.each(ValueMentor.sum_point, function (menKey, mentorPoint) {
                                $.each(mentorPoint, function (mentor, vMentor) {
                                    arrPointMentor.push(vMentor);
                                })
                            })
                        })
                        $.each(result.member, function (keyMenBer, valueMenBer) {
                            $.each(valueMenBer, function (kMenBer, vMember) {
                                if (vMember.name == 'Fresher') {
                                    $.each(valueMenBer, function (kFresher, vFrsher) {
                                        $.each(vFrsher.total_point, function (kpoint, vpoint) {
                                            arrPointFresher.push(vpoint);
                                        })
                                    })
                                }
                                if (vMember.name == 'cross') {
                                    $.each(valueMenBer, function (kCroos, vCross) {
                                        $.each(vCross.sum_point, function (kpoint, vpoint) {
                                            $.each(vpoint, function (k, v) {
                                                arrPointCross.push(v);
                                            })
                                        })

                                    })
                                }
                                if (vMember.name == 'team') {
                                    $.each(valueMenBer, function (kteam, vteam) {
                                        $.each(vteam.sum_point, function (k, v) {
                                            $.each(v, function (kpoint, vpoint) {
                                                arrPointTeam.push(vpoint);
                                            })
                                        })

                                    })
                                }
                            })
                        })

                        var ctx = document.getElementById('myAreaChart').getContext('2d');
                        var ctx2 = document.getElementById('chart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'radar',
                            width:'80%',
                            data: {
                                labels: arrMainPointFilter,
                                datasets: [{
                                    label:'# Admin',
                                    data: arrPointAdmin,
                                    backgroundColor: 'rgba(215, 44, 4, 0)',
                                    borderColor: [
                                        '#76b39d',
                                    ],
                                    borderWidth: 2
                                },
                                {
                                    label: '# Mentor',
                                    data: arrPointMentor,
                                    backgroundColor: 'rgba(215, 44, 4, 0)',
                                    borderColor: [
                                        '#05004e',
                                    ],
                                    borderWidth: 2
                                },
                                {
                                    label: '# Fresher',
                                    data: arrPointFresher,
                                    backgroundColor: 'rgba(215, 44, 4, 0)',
                                    borderColor: [
                                        '#ffcd3c',
                                    ],
                                    borderWidth: 2
                                }
                                ]
                            },
                            options: {
                                scale: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                        var myChart = new Chart(ctx2, {
                            type: 'radar',
                            data: {
                                labels: arrMainPointFilter,
                                datasets: [
                                    {
                                        label: '# Team',
                                        data: arrPointTeam,
                                        backgroundColor: 'rgba(215, 44, 4, 0)',
                                        borderColor: [
                                            '#f54291',
                                        ],
                                        borderWidth: 2
                                    },
                                    {
                                        label: '# Colleague',
                                        data: arrPointCross,
                                        backgroundColor: 'rgba(215, 44, 4, 0)',
                                        borderColor: [
                                            '#05004e',
                                        ],
                                        borderWidth: 2
                                    },
                                    {
                                        label: '# Fresher',
                                        data: arrPointFresher,
                                        backgroundColor: 'rgba(215, 44, 4, 0)',
                                        borderColor: [
                                            '#ffcd3c',
                                        ],
                                        borderWidth: 2
                                    }
                                ]
                            },
                            options: {
                                scale: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    }
                })
            })
        });
        btnclose.forEach((btnclose,index) => {
            btnclose.addEventListener('click',(e) => {
                e.preventDefault()
                location.reload(true);
            })
        })
    </script>
@endsection
