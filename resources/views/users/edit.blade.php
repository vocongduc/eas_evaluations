@extends('partials.master')
@section('content')
    <div class="modal-content" style="margin-top: -7rem">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit mới user</h5>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" method="POST" action="" >
                @csrf
                <div class="form-group row">
                    <label for="avatar" class="col-sm-2 col-form-label small">Avatar</label>
                    <div class="col-sm-10">
                        <div id="wrapp-avt-img">
                            <img class="img-profile rounded-circle" src="{{asset($user->image)}}"
                                 alt="avatar" width="50px">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Tải lên</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="avatar" onchange='openFile(event)'>
                            @error('avatar')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Họ và tên</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{$user->name}}" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" placeholder="Họ và tên">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{$user->email}}" class="form-control" disabled>
                        <input type="hidden" value="{{$user->email}}" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" placeholder="Email">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Địa chỉ</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{$user->address}}" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" id="address" name="address" placeholder="Địa chỉ">
                        @error('address')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Ngày sinh</label>
                    <div class="col-sm-10">
                        <input type="date" value="{{$user->birth_day}}" name="birthDate" class="form-control {{$errors->has('birthDate') ? 'is-invalid' : ''}}" id="address" placeholder="Ngày sinh">
                        @error('birthDate')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="numberPhone" class="col-sm-2 col-form-label">Số điện thoại</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{$user->phone}}" class="form-control {{$errors->has('phoneNumber') ? 'is-invalid' : ''}}" id="numberPhone" name="phoneNumber" placeholder="SĐT">
                        @error('phoneNumber')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @if(!$user->hasRole('admin'))
                <div class="form-group row">
                    <label for="numberPhone" class="col-sm-2 col-form-label">Roles</label>
                    <div class="col-sm-10">
                        <select class="custom-select" id="validationTooltip04" name="role">
                            <option value="">Choose Role...</option>
                            @foreach($roles as $role)
                                @if($role->name !== 'admin')
                                <option value="{{$role->id}}" {{$user->hasRole($role->id) ? 'selected' : ''}}>{{$role->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
                <div class="form-group row">
                    <label for="CourseName" class="col-sm-2 col-form-label">Khóa học </label>
                    <div class="col-sm-10">
                        <select class="custom-select listCourse" name="course_id" id="course_id">
                            <option value="">Chọn Khóa</option>
                            @foreach($listCoursesUsers as $listCoursesUser)
                                @foreach($listCoursesUser['teams'] as $team)
                                    <option value="{{$listCoursesUser->id}}" {{$listCoursesUser->id == $listCoursesUser->course_id || !empty($team) && $team['id'] == $user->team_id ? 'selected' : ''}}>{{$listCoursesUser->name}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="teamName" class="col-sm-2 col-form-label">Team</label>
                    <div class="col-sm-10">
                        <select class="custom-select team_id" name="team_id" id="team_id">
                            <option value="">Chọn Team</option>
                            @foreach($teams as $team)
                                <option value="{{$team->id}}" {{$team->id == $user->team_id ? 'selected' : ''}}>{{$team->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row" style="margin-left: 17%">
                    <a href="{{route('users.index')}}"><button type="button" class="btn btn-secondary btn-action" >Trở về</button></a>&nbsp;
                    <button type="submit" class="btn btn-primary btn-action">Lưu</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        var openFile = function(event) {
            var input = event.target;

            var reader = new FileReader();
            reader.onload = function(){
                TheFileContents = reader.result;
                document.getElementById("wrapp-avt-img").innerHTML = '<img width="50px" class="img-profile rounded-circle"" src="'+TheFileContents+'" />';
            };
            reader.readAsDataURL(input.files[0]);
        };
    </script>
@endsection
@section('inline_scripts')

    <script type="text/javascript">
        $(document).ready(function () {
            $(".listCourse").change(function () {

                if($(this).val() != '') {
                    var course_id = $(this).attr('id');
                    var value = $(this).val();
                    var token = $("input[name='_token']").val();

                    $.ajax({
                        url: "{{ route('listTeamAjax.fetch') }}",
                        method: "POST",
                        data: {course_id:course_id, value:value, _token:token},
                        success:function ($data) {
                            $("#team_id").html('');
                            $("#team_id").append($('<option>').text('Chọn team'));
                            $.each($data, function (key, value) {
                                $("#team_id").append($('<option>').val(value['id']).text(value['name']));
                            })
                        }
                    });
                }
            });

        });
    </script>
@endsection
