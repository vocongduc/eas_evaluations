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
            <form role="form" action="{{ route('formPermit.update', $formPermits->id )}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="card-body">
                    <div class="form-group ">
                        <label for="course">Tên thành viên  </label>:
                        <b style="margin-left: 20px;"> {{$formPermits->user->name}}</b>
                    </div>
                    <div class="form-group ">
                        <label for="form">Form đã phân quyền : </label>
                        <select class="form-control col-md-12 form_id"  id="form_id" name="form_id">
                            <option selected="" value="">Choose...</option>
                            @foreach($teamforms as $teamform)
                                <option value="{{ $teamform->form->id }}" {{ (($formPermits->form_id) == $teamform->form->id) ? 'selected' : '' }}>{{ $teamform->form->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="form">Chọn người đánh giá </label>
                        <select class="form-control col-md-12 role_id listRole "  name="role_id" id="role_id" data-dependent="evaluate_user_id">
                            <option selected="" value="">Choose...</option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
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
                        <input type="date" class="form-control date" name="expired_date" value="{{$formPermits->expired_date}}" >
                    </div>

                    <table class="table">
                        <tbody class="listUser"></tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-success saveBtn" >Lưu </button>
                </div>
                <input type="hidden" name="evaluate_user_id" value="{{ isset($formPermits) ? ($errors->has('evaluate_user_id') ? old('evaluate_user_id') : $arrUserEvaluteForm) : old('evaluate_user_id') }}"/>
            </form>
        </div>
    </div>
@endsection
@section('inline_scripts')

    <script>
        $(document).ready(function () {
            $('.listRole').change(function () {
                if($(this).val() != '')
                {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent =$(this).data('dependent');
                    var _token = $('input[name = "_token"]').val();
                    let listUser = document.querySelector('.listUser')
                    $.ajax({
                        url: "{{ route('userCriteria.fetch')}}",
                        method: "POST",
                        data: {select: select, value: value, _token: _token, dependent: dependent},
                        success: function (result) {
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
                            const  checkBoxs = document.querySelectorAll('.evaluate_user_id')
                            checkBoxs.forEach((checkBox,index) => {
                                checkBox.addEventListener('click', (e) => {
                                    if(checkBox.checked){
                                        const tr = e.target.parentNode.parentNode
                                        listUser.appendChild(tr)
                                    }
                                })
                            })
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


