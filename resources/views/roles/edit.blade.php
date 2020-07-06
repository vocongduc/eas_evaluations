@extends('partials.master')
@section('content')
    <div class="modal-content" style="margin-top: -7rem">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit role</h5>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" method="POST" action="" >
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Tên role :</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{$role->name}}"
                               class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                               id="name" name="name" placeholder="Tên role"  {{$role->name === 'admin' ? 'disabled' : ''}} >
                        {!! $role->name === 'admin' ? '<input name="name" type="hidden" value="'.$role->name.'">' : ''!!}
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Permissions</label>
                    <div class="col-sm-10" >
                        <div style="overflow-y: scroll;
                            height: 150px;
                            width: 398px;
                            border: 1px solid #858796;
                            padding-left: 10px;">
                            <div class="form-check">
                                <label class="form-check-label">
                                    @foreach($permissions as $key=>$permission)
                                        <input type="checkbox" class="form-check-input users"
                                               name="permission_id[]"
                                               id="{{$permission->id}}"
                                               value="{{$permission->id}}" {{$role->hasPermissionTo($permission->id) ? 'checked' : ''}}>
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
        let data = [];
        let valueUser = document.querySelectorAll('.users:checked');
        console.log(valueUser);
        valueUser.forEach((item) => {
            data.push(item.value)

        })
        console.log(data)
    </script>
@endsection
