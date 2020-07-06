@extends('partials.master')
@section('content')
    <div class="modal-content" style="margin-top: -7rem">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm mới user</h5>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" method="POST" action="{{route('users.store')}}" >
                @csrf
                <div class="form-group row">
                    <label for="avatar" class="col-sm-2 col-form-label small">Avatar</label>
                    <div class="col-sm-10">
                        <div id="wrapp-avt-img">
                            <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"
                                 alt="avatar" width="50px">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Tải lên</label>
                            <input type="file" class="form-control-file upload-file" id="exampleFormControlFile1" name="avatar" onchange='openFile(event)'>
                            @error('avatar')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Họ và tên</label>
                    <div class="col-sm-10">
{{--                        {{\Session::has('role') ? \Session::get('role') : old('role')}}--}}
                        <input type="text" value="{{\Session::has('name') ? \Session::get('name') : old('name')}}" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" placeholder="Họ và tên">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{old('email')}}" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" placeholder="Email">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
{{--                <div class="form-group row">--}}
{{--                    <label for="password" class="col-sm-2 col-form-label">Mật khẩu</label>--}}
{{--                    <div class="col-sm-10">--}}
{{--                        <input type="password" name="password" class="form-control" disabled>--}}
{{--                        @error('password')--}}
{{--                        <small class="text-danger">{{ $message }}</small>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Địa chỉ</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{old('address')}}" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" id="address" name="address" placeholder="Địa chỉ">
                        @error('address')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Ngày sinh</label>
                    <div class="col-sm-10">
                        <input type="date" value="{{old('birthDate')}}" name="birthDate" class="form-control {{$errors->has('birthDate') ? 'is-invalid' : ''}}" id="address" placeholder="Ngày sinh">
                        @error('birthDate')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="numberPhone" class="col-sm-2 col-form-label">Số điện thoại</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{old('phoneNumber')}}" class="form-control {{$errors->has('phoneNumber') ? 'is-invalid' : ''}}" id="numberPhone" name="phoneNumber" placeholder="SĐT">
                        @error('phoneNumber')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="numberPhone" class="col-sm-2 col-form-label">Roles</label>
                    <div class="col-sm-10">
                        <select class="custom-select" id="validationTooltip04" name="role">
                            <option value="">Choose Role...</option>
                            @foreach($roles as $role)
                                @if($role->name !== 'admin')
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('role')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="course" class="col-sm-2 col-form-label">Tên Khóa học </label>
                    <div class="col-sm-10">
                    <select class="custom-select listCourse" name="course_id" id="course_id">
                        <option value=""  >Chọn khóa học </option>
                        @foreach($listCoursesUsers as $listCoursesUser)
                            <option value="{{$listCoursesUser->id}}">{{$listCoursesUser->name}}</option>
                        @endforeach
                    </select>
                    </div>
                    @if ($errors->has('course_id'))
                        <span class="error" style=" font-size: 15px; font-style:italic; color:red;">{{ $errors->first('course_id') }}</span>
                    @endif
                </div>
                <div class="form-group row ">
                    <label for="team" class="col-sm-2 col-form-label">Tên team </label>
                    <div class="col-sm-10">
                    <select class="custom-select team_id" name="team_id" id="team_id">
                        <option value="" >Chọn team </option>
                    </select>
                    </div>
                    @if ($errors->has('team_id'))
                        <span class="error" style=" font-size: 15px; font-style:italic; color:red;">{{ $errors->first('team_id') }}</span>
                    @endif
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
