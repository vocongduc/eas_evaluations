@extends('partials.master')
@section('content')
    <div class="modal-content" style="margin-top: -7rem">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit permission</h5>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" method="POST" action="" >
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Họ và tên</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{$permission->name}}" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" placeholder="Tên permission">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row" style="margin-left: 17%">
                    <a href="{{route('permission.index')}}"><button type="button" class="btn btn-secondary btn-action" >Trở về</button></a>&nbsp;
                    <button type="submit" class="btn btn-primary btn-action">Lưu</button>
                </div>
            </form>
        </div>
    </div>
@endsection
