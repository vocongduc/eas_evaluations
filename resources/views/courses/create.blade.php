@extends('partials.master')

@section('title')
    <title> HyBrid-Technologies </title>
@endsection

@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <div class="row w-100 justify-content-center">
            <div class="col-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thêm Mới Khóa Học</h3>
                    </div>
                    <!-- form start -->
                    <form action="{{ route('courses.store') }}" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        @include('courses.form')
                        <input type="hidden" name="redirect_url" value="{{ old('redirect_url') ?? (url()->previous()) }} ">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->
@endsection
