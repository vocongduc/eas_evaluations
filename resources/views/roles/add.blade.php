@extends('partials.master')
@section('content')
    <div class="modal-content" style="margin-top: -7rem">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm mới role</h5>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" method="POST" action="{{route('role.store')}}" >
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Tên role :</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{old('role')}}"
                               class="form-control {{$errors->has('role') ? 'is-invalid' : ''}}"
                               id="name" name="name" placeholder="Tên role">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row" id="users">
                    <label for="name" class="col-sm-2 col-form-label">Permission</label>
                    <div class="col-sm-10" >
                        <div style="overflow-y: scroll;
                            height: 150px;
                            width: 398px;
                            border: 1px solid #858796;
                            padding-left: 10px;">
                            <div class="form-check">
                                <label class="form-check-label">
                                    @foreach($permissions as $key=>$permission)
                                        <input type="checkbox" class="form-check-input" name="permission[]" id="{{$permission->id}}" value="{{$permission->id}}">
                                        <label for="{{$permission->id}}">{{$permission->name}}</label> <br>
                                    @endforeach
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row" style="margin-left: 17%">
                    <a href="{{route('role.index')}}"><button type="button" class="btn btn-secondary btn-action" >Trở về</button></a>&nbsp;
                    <button type="submit" class="btn btn-primary btn-action">Lưu</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        let values = document.querySelector('.form-check-input');
        if (values == null){
            document.querySelector('.form-check-label').innerHTML = 'Tất cả user đã được phân quyền.</br> (<i>Lưu ý: Vẫn có thể thêm role mới.</i>)';
        }
    </script>
@endsection
