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
                    <h4 class="">Quản lý biểu mẫu đánh giá</h4>
                </div>
                <div class="col-4">
                    <!-- Search user -->
                    <form method="get" action="{{ route('forms.index') }}" accept-charset="UTF-8">
                        <div class="input-group md-form form-sm form-2 pl-0 ">
                            <input class="form-control my-0 py-1 red-border" type="text" name="searchName" placeholder="Search" aria-label="Search" value="{{ request()->searchName }}">
                            <div class="input-group-append">
                                <input type="submit" class="input-group-text red lighten-3" id="basic-text1" name="search" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-5">
                    <!-- add new user button -->
                    <div class="d-flex justify-content-end align-items-center ">
                        <a href="{{ route('forms.create') }}">
                            <input type="submit" class="btn btn-primary float-right" value="Thêm mới Form">
                        </a>
                        <!-- Add new user form -->

                    </div>

                </div>
            </div>
            <div class="col-12">
                @include('flash::message')
            </div>
            @if(count($forms) == 0)
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
                            <th class="text-left" scope="col">Tiêu đề form</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = ($forms->currentpage() - 1) * $forms->perpage() + 1; @endphp
                        @foreach($forms as $form)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td class="text-left">{{ $form->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($form->crated_at)->format('d/m/Y') }}</td>
                                <td>
                                    @if (count($form->teamForms) >0)
                                        @foreach($form->teamForms as $teamform)
                                            @if ($teamform->status == 1)
                                                Assign
                                            @else
                                                NonAssign
                                            @endif
                                        @endforeach
                                    @else
                                        NonAssign
                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('forms.show', $form->id) }}" style="text-decoration: none">
                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#courseDetail"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                    </a>

                                    <a href="{{ route('forms.edit', $form->id) }}" style="text-decoration: none">
                                        <input type="submit" class="btn btn-primary" value="Sửa">
                                    </a>
                                    <button class="btn btn-danger delete-button fuction-size margin" type="button" record-id="{{ $form->id }}" name-page="{{ route('forms.index') }}"
                                            data-toggle="modal" data-target="#delete-modal"
                                                @if (count($form->teamForms) >0)
                                                    @foreach($form->teamForms as $teamform)
                                                    @if ($teamform->status == 1)
                                                        {{'disabled'}}
                                                        @endif
                                                    @endforeach
                                                @endif>
                                            <i class="fa fa-trash"></i> Xóa
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
                            {{ $forms->links() }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

