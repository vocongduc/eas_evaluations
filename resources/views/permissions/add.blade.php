@extends('partials.master')
@section('content')
    <div class="modal-content" style="margin-top: -7rem">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm mới permission</h5>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" method="POST" action="{{route('permission.store')}}" >
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Tên Permission</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{old('name')}}" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" placeholder="Tên permission">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Roles</label>
                    <div class="col-sm-10">
                        <div style="overflow-y: scroll;
                            height: 150px;
                            width: 332px;
                            border: 1px solid #858796;
                            padding-left: 10px;">
                            <div class="form-check">
                                <label class="form-check-label">
                                    @foreach($roles as $key=>$role)
                                        <input type="checkbox" class="form-check-input" name="roles[]" id="{{$role->id}}" value="{{$role->id}}">
                                        <label for="{{$role->id}}">{{$role->name}}</label> <br>
                                    @endforeach
                                </label>
                            </div>
                        </div>
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
