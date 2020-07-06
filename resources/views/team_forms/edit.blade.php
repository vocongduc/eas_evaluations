@extends('partials.master')
@section('title')
    <title> Hybrid </title>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật phân quyền form </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('teamForm.update',$teamForm->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group " style="display: flex">
                        <label for="course">Tên Khóa học </label>:
                        <b style="margin-left: 20px;"> {{$course -> name}}</b>

                    </div>
                    <div class="form-group ">
                        <label for="team">Tên team : </label>
                        <b style="margin-left: 20px;"> {{ $teamForm->team->name }}</b>
                    </div>
                    <div class="form-group ">
                        <label for="form">Tên Form </label>
                        <select  class="form-control col-md-12" name="form_id" id="form_id">
                            <option value=""  >Chọn form </option>
                            @foreach($form as $val)
                                <option value="{{$val->id}}" @if($val->id == $teamForm->form_id) selected @endif>{{$val->name}}</option>
                            @endforeach
                        </select>
                        @error('form_id')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="date">Ngày hết hạn </label>
                        <input type="date" class="form-control date" name="expired_date"  value="{{ $teamForm->expired_date }}">
                    </div>
                </div>
                <!-- /.card-body -->
                <input type="hidden" name="team_id" value="{{ $teamForm->team_id }}">

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Thêm mới">
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#course").on('change', function () {
                var courseId = $(this).val();
                //console.log(courseId);
                $.ajax({
                    type: "GET",
                    url: '{!! URL::to('/formPermit/findTeamName') !!}}',
                    data: { 'id':course},
                    success:function (data) {
                        console.log('success');
                        console.log(data);
                    },
                    error:function () {

                    }
                });
            });

        });
    </script>
@endsection



