@extends('partials.master')
@section('title')
    <title> Cập nhật Mainpoint</title>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật Mainpoint </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('mainpoints.update',$mainpointDetails->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="mainpoint">Tên Mainpoint</label>
                        <input type="text" class="form-control" name="name" value="{{$mainpointDetails->name}}" required>
                        @if ($errors->has('name'))
                            <span class="error" style=" font-size: 15px; font-style:italic; color:red;">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="mainpoint">Độ ưu tiên</label>
                        <input type="number" class="form-control" name="priority"  value="{{$mainpointDetails->priority}}" required>
                        @if ($errors->has('priority'))
                            <span class="error" style=" font-size: 15px; font-style:italic; color:red;">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="point">Tổng điểm</label>
                        <input type="number" class="form-control" name="total_point"  value="{{$mainpointDetails->total_point}}" min="0" max="100" required>
                        @if ($errors->has('total_point'))
                            <span class="error" style=" font-size: 15px; font-style:italic; color:red;">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Cập nhật">
                    <a href="{{route('mainpoints.index')}}" >
                        <button type="button" class="btn btn-primary">  Quay lại  </button>
                    </a>
                </div>
            </form>
        </div>

        </div>

    </div>

@endsection
