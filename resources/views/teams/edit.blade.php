@extends('partials.master')

@section('title')
    <title> HyBrid-Technologies </title>
@endsection

@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Cập Nhật Team</h3>
                    </div>
                    <form action="{{ route('teams.update', $team->id) }}" method="post" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        @csrf
                        @include('teams.form')
                        <input type="hidden" name="redirect_url" value="{{ old('redirect_url') ?? (url()->previous()) }} ">
                    </form>
                </div>
            </div>
        </div>
    </div>>
    <!-- End of Page Wrapper -->
@endsection
