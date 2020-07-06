@extends('partials.master')

@section('title')
    <title> HyBrid-Technologies </title>
@endsection

@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper" style="margin-top: -80px;">
        <div class="row w-100 justify-content-center">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Chi Tiết Khóa Học</h3>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="nameCourse" class="col-sm-2 col-form-label">Tên khóa học</label>
                                <div class="col-sm-10">
                                    <p class="nameCourse">{{ $getcourse->name }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="startDate" class="col-sm-2 col-form-label">Ngày bắt đầu</label>
                                <div class="col-sm-10">
                                    <p class="startDateCourse">{{ \Carbon\Carbon::parse($getcourse->date_start)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="endDate" class="col-sm-2 col-form-label">Ngày kết thúc</label>
                                <div class="col-sm-10">
                                    <p class="endDateCourse">{{ \Carbon\Carbon::parse($getcourse->date_end)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleFormControlTextarea1" class="col-sm-2 col-form-label">Mô tả</label>
                                <div class="col-sm-10">
                                    <p class="descriptionCourse">{!!$getcourse->description!!} </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleFormControlTextarea1" class="col-sm-2 col-form-label">Team</label>
                                <div class="col-sm-10">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Team</th>
                                            <th scope="col">Thành viên</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($getcourse->teams as $team)
                                        <tr>
                                            <th scope="row">{{ $count++ }}</th>
                                            <td>{{ $team->name }}</td>
                                            <td>
                                                <div class="list-group">
                                                    <ul class="list-group">
                                                        @foreach($team->users as $user)
                                                            <li class="list-group-item">{{$user->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('courses.index') }}">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </a>

                    </div>
                </div>
                <!-- general form elements -->
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->
@endsection
