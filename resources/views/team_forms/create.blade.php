@extends('partials.master')
@section('title')
    <title> Hybrid </title>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thêm mới phân quyền form </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('teamForm.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("POST")
                <div class="card-body">
                    <div class="form-group ">
                        <label for="course">Tên Khóa học </label>
                        <select class="form-control col-md-12 listCourse" name="course_id" id="course_id">
                            <option value=""  >Chọn khóa học </option>
                            @foreach($listCourses as $listCourse)
                                <option value="{{$listCourse->id}}">{{$listCourse->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('course_id'))
                            <span class="error" style=" font-size: 15px; font-style:italic; color:red;">{{ $errors->first('course_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group ">
                        <label for="team">Tên team </label>
                        <select class="form-control col-md-12 team_id" name="team_id" id="team_id">
                            <option value="" >Chọn team </option>
                        </select>
                        @if ($errors->has('team_id'))
                            <span class="error" style=" font-size: 15px; font-style:italic; color:red;">{{ $errors->first('team_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group ">
                        <label for="form">Tên Form </label>
                        <select  class="form-control col-md-12" name="form_id" id="form_id">
                            <option value=""  >Chọn form </option>
                            @foreach($listForms as $form)
                                <option value="{{$form->id}}">{{$form->name}}</option>
                            @endforeach
                        </select>
                        @error('form_id')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="date">Ngày hết hạn </label>
                        <input type="date" class="form-control date" name="expired_date" id="expired_date" >
                        @error('expired_date')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-success" >Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
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
                            $("#team_id").append($('<option>').text('chon team'));
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


