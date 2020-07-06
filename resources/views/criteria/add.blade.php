@extends('partials.master')
@section('title')
    <title> Thêm mới tiêu chí </title>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thêm tiêu chí </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('criterias.store') }}" method="POST" enctype="multipart/form-data"> {{csrf_field()}}
                <div class="card-body">
                    <div class="form-group ">
                        <label for="mainpoint">Tên danh mục </label>
                        <select  class="form-control col-md-12" name="category_id" id="category_id">
                            @foreach($categories as $cate)
                                <option value="{{$cate->id}}">{{$cate->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="criteria">Tên tiêu chí </label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập tên tiêu chí">
                        @error('name')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pointmax">Điểm tuyệt đối </label>
                        <input type="text" class="form-control" name="point_max"  id="point_max" placeholder="Nhập tên điểm" >
                        @error('point_max')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pointweight">Trọng số </label>
                        <input type="text" class="form-control" name="point_weight"  id="point_weight" placeholder="Nhập trọng số" >
                        @error('point_weight')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả</label><br>
                        <textarea name="desc" id="editor1" cols="30" rows="5" class="form-control"></textarea>
                        @error('desc')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Thêm mới">
                </div>
            </form>
        </div>
    </div>

@endsection
