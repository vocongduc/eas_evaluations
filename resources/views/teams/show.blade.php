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
                        <h3 class="card-title">Chi Tiết Team</h3>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="nameCourse" class="col-sm-2 col-form-label">Tên Team</label>
                                <div class="col-sm-10">
                                    <p class="nameCourse">{{ $teams->name }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleFormControlTextarea1" class="col-sm-2 col-form-label">Team</label>
                                <div class="col-sm-10">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Thành viên</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <th scope="row">{{ $user->id }}</th>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('teams.index') }}">
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
