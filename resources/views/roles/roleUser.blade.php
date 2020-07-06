@extends('partials.master')
@section('content')
    <div class="modal-content" style="margin-top: -7rem">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm quyền cho user.</h5>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" method="POST" action="{{route('role.user.store')}}" >
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Họ và tên</label>
                    <div class="col-sm-10">
                        <div style="overflow-y: scroll;
                            height: 150px;
                            width: 398px;
                            border: 1px solid #858796;
                            padding-left: 10px;">
                            <div class="form-check">
                                <label class="form-check-label">
                                    @foreach($users as $key=>$user)
                                        @if(!$user->hasAnyRole(Role::all()))
                                            <input type="checkbox" class="form-check-input" name="users[]" id="{{$user->id}}" value="{{$user->id}}">
                                            <label for="{{$user->id}}">{{$user->name}}</label> <br>
                                        @endif
                                    @endforeach
                                </label>
                            </div>
                        </div>
                        @if (!empty(Session::has('userErr')))
                            <small class="text-danger">{!! \Session::get('userErr')!!}</small>
                        @endif
                    </div>
                </div>

                <div class="form-group row" id="roles">
                    <label for="name" class="col-sm-2 col-form-label">Roles</label>
                    <div class="col-sm-10">
                        <select name="role" id="" class="form-control" style="width: 30%">
                            <option value="">Select Role</option>
                            @foreach($roles as $key=>$role)
                                @if($role->name !== 'admin')
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ( !empty(Session::has('roleErr')))
                            <br><small class="text-danger">{!! \Session::get('roleErr') !!}</small>
                        @endif
                    </div>
                </div>

                <div class="form-group row" style="margin-left: 17%">
                    <a href="{{route('role.index')}}"><button type="button" class="btn btn-secondary btn-action" >Trở về</button></a>&nbsp;
                    <p id="btnSave"><button type="submit" class="btn btn-primary btn-action">Lưu</button></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        let values = document.querySelector('.form-check-input');
        if (values == null){
            document.querySelector('.form-check-label').innerHTML = 'Tất cả user đã được phân quyền.';
            document.querySelector('#roles').innerHTML = '';
            document.querySelector('#btnSave').innerHTML = '';
        }
    </script>
@endsection
