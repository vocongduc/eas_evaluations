@extends('partials.master')
@section('title')
    <title> Cập nhật tiêu chí </title>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật tiêu chí </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{route('criterias.update',$criteriaDetails->id)}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="criteria">Tên tiêu chí </label>
                        <input type="text" class="form-control" name="name" value="{{$criteriaDetails->name}}"  required>

                    </div>
                    <div class="form-group ">
                        <label for="category">Tên Danh mục </label>
                        <select  class="form-control col-md-12" name="category_id" id="category_id">
                            @foreach($categories as $val)
                                <option value="{{$val->id}}" @if($val->id == $criteriaDetails->category_id) selected @endif>{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pointweight">Điểm tuyệt đối </label>
                        <input type="number" class="form-control" name="point_max" value="{{$criteriaDetails->point_weight}}" min="0" max="100"  required>
                    </div>
                    <div class="form-group">
                        <label for="pointmax">Trọng số </label>
                        <input type="number" class="form-control" name="point_weight" value="{{$criteriaDetails->point_max}}" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả</label><br>
                        <textarea name="desc" id="editor1" cols="30" rows="5" class="form-control">{{$criteriaDetails->description}}</textarea>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Cập nhật">
                    <a href="{{route('criterias.index')}}" >
                        <button type="button" class="btn btn-primary">  Quay lại  </button>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-3"></div>
@endsection
