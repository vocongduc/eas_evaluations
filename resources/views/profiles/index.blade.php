@extends('partials.master')

@section('title')
    <title> HyBrid-Technologies </title>
@endsection

@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <div class="container-fluid">

            <div class="head-action row mb-5">
                <div class="col-6">
                    <h4 class="">Cập nhật thông tin cá nhân</h4>
                </div>

                <div class="col-6">
                    <!-- add new user button -->
                    <div class="d-flex justify-content-end align-items-center ">
                        <a href="{{ asset('profile/edit/'.Auth::user()->id) }}" style="text-decoration: none">
                            <input type="submit" class="btn btn-primary" value="Cập nhật thông tin cá nhân">
                        </a>
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="card" style="width:80%">
                                @if ($profile->image == '')
                                    <img src="{{ asset('img/images.jpeg') }}" class="card-img-top" alt="...">
                                @else
                                    <img src="{{ asset($profile->image) }}" class="card-img-top" alt="...">
                                @endif
                            </div>
                        </div>
                        <div class="col-8">

                            <div class="row">
                                <!--Flass message upadte profile success or false -->
                                <div class="col-12">
                                    @include('flash::message')
                                </div>
                                <div class="col-6">
                                    <div class="user-info">
                                        <!-- user info title -->
                                        <!-- user info description -->
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr>
                                                <th scope="col">Họ tên</th>
                                                <td>{{ $profile->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Ngày sinh</th>
                                                @if ($profile->birth_day == '')
                                                    <td></td>
                                                @else
                                                    <td>{{ \Carbon\Carbon::parse($profile->birth_day)->format('d/m/Y') }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="col">Số điện thoại</th>
                                                @if ($profile->phone == '')
                                                    <td></td>
                                                @else
                                                    <td>{{ $profile->phone }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="col">Địa chỉ</th>
                                                @if ($profile->address == '')
                                                    <td></td>
                                                @else
                                                    <td>{{ $profile->address }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="col">Email</th>
                                                <td>{{ $profile->email }}</td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('home') }}">
                            <input type="submit" class="btn btn-danger" value="Quay Lại">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->
@endsection
