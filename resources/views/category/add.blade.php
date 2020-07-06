@extends('partials.master')
@section('title')
    <title> Quản lý Danh mục </title>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thêm danh mục </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"> {{csrf_field()}}
                <div class="card-body">
                    <div class="form-group ">
                        <label for="mainpoint">Tên Mainpoint</label>

                        <select  class="form-control col-md-12" name="main_point_id" id="main_point_id">
                            @foreach($mainpoints as $mainpoint)
                            <option value="{{$mainpoint->id}}">{{$mainpoint->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="point">Tên danh mục</label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập tên danh mục" required>
                        @if ($errors->any())
                            <ul>{!! implode('', $errors->all('<li style="color:red">:message</li>')) !!}</ul>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="mainpoint">Thứ tự</label>
                        <input type="number" class="form-control" name="priority"  value="1" min="0" required>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Thêm mới">
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-3"></div>
@endsection
