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
                <div class="col-2">
                    <h4 class="">Quản lý Team</h4>
                </div>
                <div class="col-4">
                    <!-- Search user -->
                    <form method="get" action="{{ route('teams.index') }}" accept-charset="UTF-8">
                        <div class="input-group md-form form-sm form-2 pl-0 ">
                            <input class="form-control my-0 py-1 red-border" type="text" name="searchName" placeholder="Search" aria-label="Search" value="{{ request()->searchName }}">
                            <div class="input-group-append">
                                <input type="submit" class="input-group-text red lighten-3" id="basic-text1" name="search" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-6">
                    <!-- add new user button -->
                    <div class="d-flex justify-content-end align-items-center ">
                        <a href="{{ route('teams.create') }}">
                            <input type="submit" class="btn btn-primary float-right" value="Thêm mới Team">
                        </a>
                        <!-- Add new user form -->
                    </div>
                </div>
            </div>
            <div class="col-12">
                @include('flash::message')
            </div>
            @if(count($teams) == 0)
                <div class="row">
                    <div class="col-md-12 text-danger text-center">
                        <h2>Không tìm thấy bản ghi.</h2>
                    </div>
                </div>
            @else
                <div class="row">
                    <table class="table table-hover" style="text-align: center">
                        <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th class="text-left" style="text-align: center !important;">Tên Team</th>
                            <td class="text-left" style="text-align: center !important;">Tên Khóa học</td>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = ($teams->currentpage() - 1) * $teams->perpage() + 1; @endphp
                        @foreach($teams as $team)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td class="text-left" style="text-align: center !important;">{{ $team->name }}</td>

                                <td class="text-left" style="text-align: center !important;">{{ $team->course->name }}</td>
                                <td>
                                    <a href="{{ route('teams.show', $team->id) }}" style="text-decoration: none">
                                        <button type="button" class="btn btn-secondary" data-toggle="modal"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                    </a>

                                    <a href="{{ route('teams.edit', $team->id) }}" style="text-decoration: none">
                                        <input type="submit" class="btn btn-primary" value="Sửa">
                                    </a>
                                    <button class="btn btn-danger delete-button fuction-size margin" type="button" record-id="{{ $team->id }}" name-page="{{ route('teams.index') }}"
                                            data-toggle="modal" data-target="#delete-modal"><i class="fa fa-trash"></i> Xóa
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
                            {{ $teams->links() }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- End of Page Wrapper -->
@endsection
