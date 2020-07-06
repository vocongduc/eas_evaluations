@extends('partials.master')
@section('title')
    <title> Hybrid </title>
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thêm mới phân quyền đánh giá chéo </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{route('formPermit.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group ">
                        <label for="course">Tên Khóa học </label>
                        <select class="form-control dynamic col-md-12 course_id"  id="course_id" name="course_id" data-dependent="team_id">
                            <option value=""> Chọn khóa học </option>
                                @foreach($listCourses as $listCourse)
                                    <option value="{{$listCourse->id}}">{{$listCourse->name}}</option>
                                @endforeach
                        </select>
                        @error('course_id')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="team">Tên team </label>
                        <select class="form-control dynamic col-md-12 team_id"  id="team_id" name="team_id" data-dependent="user_id">
                            <option selected="" value="">Choose...</option>
                        </select>
                        @error('team_id')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="form">Chọn thành viên : </label>
                        <select class="form-control dynamic col-md-12 user_id"  id="user_id" name="user_id" data-dependent="form_id">
                            <option selected="" value="">Choose...</option>
                        </select>
                        @error('user_id')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="form">Form đã phân quyền : </label>
                        <select class="form-control col-md-12 form_id"  id="form_id" name="form_id">
                            <option selected="" value="">Choose...</option>
                        </select>
                        @error('form_id')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="form">Chọn người đánh giá </label>
                        <select class="form-control col-md-12 role_id listRole "  name="role_id" id="role_id" data-dependent="evaluate_user_id">
                            <option selected="" value="">Choose...</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="categories-block mb-4">
                            <p class="h5 mb-2"></p>
                            <!-- table point -->
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Chọn</th>
                                    <th scope="col">Tên</th>
                                </tr>
                                </thead>
                                <tbody id="evaluate_user_id" name="evaluate_user_id" >
                                <tr></tr>
                                </tbody>
                            </table>
                        </div>
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
                <input type="hidden" id="evaluate_user_id"  name="evaluate_user_id" value=""/>
                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Thêm mới">
                </div>

            </form>
        </div>
    </div>
@endsection
@section('inline_scripts')
    <script>
        $(document).ready(function () {
           $('.dynamic').change(function () {
                if($(this).val() != '')
                {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent =$(this).data('dependent');
                    var _token = $('input[name = "_token"]').val();
                    $.ajax({
                        url: "{{ route('dynamicDependent.fetch')}}",
                        method: "POST",
                        data:{select:select, value:value, _token:_token, dependent:dependent },
                        success:function (result) {
                            if (select == 'course_id') {
                                $('#team_id').html('');
                                $('#team_id').append($('<option>').text('Choose..'));
                                $.each(result, function (key, value) {
                                    $('#team_id').append($('<option>').val(value['id']).text(value['name']));
                                })
                            }
                            else if (select == 'team_id') {

                                $('#user_id').html('');
                                $('#user_id').append($('<option>').text('Choose..'));
                                $.each(result, function (key, value) {
                                    $('#user_id').append($('<option>').val(value['id']).text(value['name']));
                                })
                            } else {
                                $('#form_id').html('');
                                $('#form_id').append($('<option>').text('Choose..'));
                                $.each(result, function (key, value) {
                                    $('#form_id').append($('<option>').val(value['id']).text(value['name']));
                                })
                            }
                        }
                    })
                }
               $('#course_id').change(function(){
                   $('#team_id').val('');
                   $('#user_id').val('');
                   $('#form_id').val('');
               });
               $('#team_id').change(function(){
                   $('#user_id').val('');
                   $('#form_id').val('');
               });
               $('#user_id').change(function(){
                   $('#form_id').val('');
               });
           });
           $('.listRole').change(function () {
               if($(this).val() != '')
               {
                   var select = $(this).attr("id");
                   var value = $(this).val();
                   var dependent =$(this).data('dependent');
                   var _token = $('input[name = "_token"]').val();
                   $.ajax({
                       url: "{{ route('userCriteria.fetch')}}",
                       method: "POST",
                       data: {select: select, value: value, _token: _token, dependent: dependent},
                       success: function (result) {
                           var user = document.getElementById("user_id");
                           var user_id = user.options[user.selectedIndex].value;

                           if (user_id != '') {

                           }
                           console.log(result)
                           if (select == 'role_id') {
                               $('#evaluate_user_id').html('');
                               var count = 1;
                               $.each(result, function (key, value) {
                                   $.each(value.users, function (keyUser, user) {
                                       $('#evaluate_user_id').append(
                                           "<tr>" +
                                           "<td>" + count++ + "</td>" +
                                           "<td>" + "<input type = 'checkbox' class='checkbox criterias evaluate_user_id' " +
                                           "aria-label='Checkbox for following text input' name='evaluate_user_id[]' value=" + user.id + ">" + "</td>" +
                                           "<td>" + user.name + "</td>" +
                                           "</tr>"
                                       );
                                   });

                               });
                           }
                           var input = $('input[name=evaluate_user_id]').val().split(',');
                           $('.evaluate_user_id').each(function() {
                               if (input.includes($(this).val())) {
                                   $(this).prop('checked', true);
                               } else {
                                   $(this).prop('checked', false);
                               }
                           })
                       }
                   });
               }
            });
            $('body').on('click', '.evaluate_user_id', function() {
                if ($(this).is(':checked')) {
                    var val = $(this).val();
                    var input = $('input[name=evaluate_user_id]').val();
                    var inputArr = [];
                    if (input != "") {
                        inputArr = input.split(',');
                    }
                    if (!inputArr.includes(val)) {
                        inputArr.push(val);
                    }
                    $('input[name=evaluate_user_id]').val(inputArr.join(','));
                } else {
                    var val = $(this).val();
                    var input = $('input[name=evaluate_user_id]').val();
                    var inputArr = [];
                    if (input != "") {
                        inputArr = input.split(',');
                    }
                    inputArr.splice(inputArr.indexOf(val), 1);
                    $('input[name=evaluate_user_id]').val(inputArr.join(','));
                }
            })
        });
    </script>
@endsection
