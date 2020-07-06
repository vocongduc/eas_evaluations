@extends('partials.master')

@section('title')
    <title> HyBrid-Technologies </title>
@endsection

@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper" style="margin-top: -100px !important; ">
        <div class="row w-100 justify-content-center" >
            <div class="col-10" >
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Cập Nhật Form</h3>
                    </div>
                    <!-- form start -->
                    <form action="{{ route('forms.update', $form->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('forms.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('inline_scripts')


    <script>
        $(document).ready(function () {
            $('.dynamic').change(function () {

                if ($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var token = $("input[name='_token']").val();
                    $.ajax({
                        url: "{{ route('fetch_data.fetch') }}",
                        method: "POST",
                        data: {select:select, value:value, _token:token, dependent:dependent},
                        success:function (result) {
                            if (select == 'main_point_id') {
                                $('#category_id').html('');
                                $('#category_id').append($('<option>').text('Choose..'));
                                $.each(result, function (key, value) {
                                    $('#category_id').append($('<option>').val(value['id']).text(value['name']));
                                })
                            }
                            if (select == 'category_id') {
                                $('#criteria_id').html('');
                                var count = 1;
                                $.each(result, function (key, value) {
                                    $('#criteria_id').append(
                                        "<tr>" +
                                        "<td>" + count++ + "</td>" +
                                        "<td>" + "<input type = 'checkbox' class='checkbox criterias criteria_id' " +
                                        "aria-label='Checkbox for following text input' name='criteria_id[]' value=" + value.id +">" + "</td>" +
                                        "<td>" + value.name  + "</td>" +
                                        "<td>" + value.point_weight  + "</td>" +
                                        "</tr>"
                                    );
                                })
                            }
                            var input = $('input[name=criteria_id]').val().split(',');
                            $('.criteria_id').each(function() {
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
            $('body').on('click', '.criteria_id', function() {
                if ($(this).is(':checked')) {
                    var val = $(this).val();
                    var input = $('input[name=criteria_id]').val();
                    var inputArr = [];
                    if (input != "") {
                        inputArr = input.split(',');
                    }
                    if (!inputArr.includes(val)) {
                        inputArr.push(val);
                    }
                    $('input[name=criteria_id]').val(inputArr.join(','));
                } else {
                    var val = $(this).val();
                    var input = $('input[name=criteria_id]').val();
                    var inputArr = [];
                    if (input != "") {
                        inputArr = input.split(',');
                    }
                    inputArr.splice(inputArr.indexOf(val), 1);
                    $('input[name=criteria_id]').val(inputArr.join(','));
                }
            })
        });
    </script>
@endsection
