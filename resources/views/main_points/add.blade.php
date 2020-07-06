@extends('partials.master')
@section('title')
    <title>Thêm mới Mainpoint</title>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thêm mainpoint </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('mainpoints.store') }}" method="POST" enctype="multipart/form-data"> {{csrf_field()}}
                <div class="card-body">
                    <div class="form-group">
                        <label for="mainpoint">Tên Mainpoint</label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập mainpoint"  >
                        @if ($errors->has('name'))
                            <span class="error" style=" font-size: 15px; font-style:italic; color:red;">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="mainpoint">Độ ưu tiên </label>
                        <input type="number" class="form-control" name="priority"  value="1" min="0" required >
                        @if ($errors->has('priority'))
                            <span class="error">{{ $errors->first('priority') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="point">Tổng điểm</label>
                        <input type="number" class="form-control" name="total_point" placeholder="Nhập điểm" required min="0" max="100">
                        @if ($errors->has('total_point'))
                            <span class="error">{{ $errors->first('total_point') }}</span>
                        @endif
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
