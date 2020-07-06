@extends('partials.master')

@section('title')
    <title> HyBrid-Technologies </title>
@endsection

@section('content')
    <!-- Page Wrapper -->
    @if(auth()->user()->hasRole('member'))
        <div id="wrapper">
            <div class="head-action row mb-5">
                <div class="col-3">
                    <h4 class="">Quản Lý Đánh Giá Cá Nhân</h4>
                </div>
            </div>
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <canvas id="myAreaChart"></canvas>
                        <p id="content-chart" style="text-align: center; font-weight: bold; margin-top: 20px; color: black"></p>
                    </div>
                    <div class="col-6">
                        <canvas id="Flowchart"></canvas>
                        <p id="chart" style="text-align: center; font-weight: bold; margin-top: 20px; color: black"></p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End of Page Wrapper -->
@endsection

@section('inline_scripts')
    @if(auth()->user()->hasRole('member'))
        <script type="text/javascript">
            $.ajax({
                url: "{{ route('listpoint.getall') }}",
                method: "GET",
                success:function (result) {
                    var arrMainPoint = [];
                    $.each(result, function (key, value) {
                        var arrMainPoint = value.main_point_id;
                        var arrMainPointFilter = arrMainPoint.filter((item, index) => arrMainPoint.indexOf(item) === index);
                        var arrPointAdmin = [];
                        var arrPointMentor = [];
                        var arrPointCross= [];
                        var arrPointTeam= [];
                        var arrPointFresher= [];
                        $.each(value.admin, function (keyAdmin, ValueAdmin) {
                            $.each(ValueAdmin.sum_point, function (aKey, adminKey) {
                                $.each(adminKey, function (admin, vAdmin) {
                                    arrPointAdmin.push(vAdmin);
                                })
                            })
                        })
                        $.each(value.mentor, function (keyMenTor, ValueMentor) {
                            $.each(ValueMentor.sum_point, function (menKey, mentorPoint) {
                                $.each(mentorPoint, function (mentor, vMentor) {
                                    arrPointMentor.push(vMentor);
                                })
                            })
                        })
                        $.each(value.member, function (keyMenBer, valueMenBer) {
                            $.each(valueMenBer, function (kMenBer, vMember) {
                                if (vMember.name == 'Fresher') {
                                    $.each(valueMenBer, function (kFresher, vFrsher) {
                                        $.each(vFrsher.total_point, function (kpoint, vpoint) {
                                            arrPointFresher.push(vpoint);
                                        })
                                    })
                                } if (vMember.name == 'cross') {
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
                        var chart = document.getElementById('Flowchart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'radar',
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
                                }]
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
                        var myChart = new Chart(chart, {
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
                        $( "p#content-chart" ).append( "Biểu Đồ Đánh Giá Admin,Mentor" );
                        $( "p#chart" ).append( "Biểu Đồ Đánh Giá Cá Nhân Team, Colleague" );
                    })
                }
            });
        </script>
    @endif
@endsection
