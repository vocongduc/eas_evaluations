@extends('partials.master')
@section('title')
    <title> Cập nhật danh mục</title>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật danh mục </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{route('categories.update',$cateDetails->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group ">
                        <label for="mainpoint">Tên Mainpoint</label>

                        <select  class="form-control col-md-12" name="main_point_id" id="main_point_id">
                            @foreach($levels as $val)
                                <option value="{{$val->id}}" @if($val->id == $cateDetails->main_point_id) selected @endif>{{$val->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="point">Tên danh mục</label>
                        <input type="text" class="form-control" name="name" value="{{$cateDetails->name}}"  required>
                        @if ($errors->has('name'))
                            <span class="error" style=" font-size: 15px; font-style:italic; color:red;">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="mainpoint">Độ ưu tiên</label>
                        <input type="number" class="form-control" name="priority"   min="0" value="{{$cateDetails->priority}}" required>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Cập nhật">
                    <a href="{{route('categories.index')}}" >
                        <button type="button" class="btn btn-primary">  Quay lại  </button>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-3"></div>
@endsection
