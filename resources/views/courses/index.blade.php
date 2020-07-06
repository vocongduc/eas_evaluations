@extends('partials.master')

@section('title')
    <title> HyBrid-Technologies </title>
@endsection

@section('content')
    @include('vendor.flash.modal')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <div class="container-fluid">
            <div class="head-action row mb-5">
                <div class="col-3">
                    <h4 class="">Quản lý khóa học</h4>
                </div>
                <div class="col-4">
                    <!-- Search user -->
                    <form method="get" action="{{ route('courses.index') }}" accept-charset="UTF-8">
                        <div class="input-group md-form form-sm form-2 pl-0 ">
                            <input class="form-control my-0 py-1 red-border" type="text" name="searchName" value="{{ request()->searchName }}" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <input type="submit" class="input-group-text red lighten-3" id="basic-text1" name="search" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-5">
                    <!-- add new user button -->
                    <div class="d-flex justify-content-end align-items-center ">
                        <a href="{{ route('courses.create') }}">
                            <input type="submit" class="btn btn-primary float-right" value="Thêm mới khóa học">
                        </a>
                        <!-- Add new user form -->

                    </div>

                </div>
            </div>
            <div class="col-12">
                @include('flash::message')
            </div>
            @if(count($courses) == 0)
                <div class="row">
                    <div class="col-md-12 text-danger text-center">
                        <h2>Không tìm thấy bản ghi.</h2>
                    </div>
                </div>
            @else
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th class="text-left" scope="col">Tên khóa học</th>
                            <th scope="col">Ngày bắt đầu</th>
                            <th scope="col">Ngày kết thúc</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = ($courses->currentpage() - 1) * $courses->perpage() + 1; @endphp
                        @foreach($courses as $course)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td class="text-left">{{ $course->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($course->date_start)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($course->date_end)->format('d/m/Y') }}</td>
                                <td>
                                    <?php
                                        $result = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($course->date_start), false);
                                        $structure = \Carbon\Carbon::parse($course->date_end)->diffInDays(\Carbon\Carbon::now(), false);
                                        if ($result > 0 ) {
                                            echo '<i class="color-stop-hd fas fa-toggle-off"></i> Chưa Hoạt Động';
                                        } elseif ($structure > 0) {
                                            echo '<i class="color-stop fas fa-stop-circle"></i> Đã Kết Thúc';
                                        }
                                        else {
                                            echo '<i class="color-i fas fa-check-circle"></i> Đang Hoạt Động';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="{{ route('courses.show', $course->id) }}" style="text-decoration: none">
                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#courseDetail"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                    </a>

                                    <a href="{{ route('courses.edit', $course->id) }}" style="text-decoration: none">
                                        <input type="submit" class="btn btn-primary" value="Sửa">
                                    </a>
                                    <button class="btn btn-danger delete-button fuction-size margin" type="button" record-id="{{ $course->id }}" name-page="{{ route('courses.index') }}"
                                            data-toggle="modal" data-target="#delete-modal" {{ $result <= 0 ? 'disabled' : '' }} ><i class="fa fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="row">
                    <div class="col-12">
                        <nav aria-label="Page navigation example" >
                            {{ $courses->links() }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

