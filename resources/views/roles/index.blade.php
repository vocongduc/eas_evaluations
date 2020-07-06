@extends('partials.master')
@section('content')
    <div class="container-fluid">
        <div class="head-action row mb-5">
            <div class="col-6">
                <h4 class="">Quản lý roles</h4>
            </div>
            <div class="col-6">
                <!-- add new user button -->
                @hasrole('admin')
                <div class="d-flex justify-content-end align-items-center ">
                    <a href="{{route('role.add')}}"><button type="button" class="btn btn-primary" >Thêm mới role</button></a>
                    <!-- Add new user form -->
                </div>
                @endhasrole
            </div>
        </div>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="table-responsive-sm table-responsive-md table-small-custom ">
            <table class="table table-hover mb-5 text-center">
                <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th class="text-left" scope="col">Tên roles</th>
                    <th class="text-left" scope="col">Tên Permissions</th>
                    @hasrole('admin')
                    <th scope="col">Action</th>
                    @endhasrole
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role )
                    <tr>
                        <th scope="row">{{$count++}}</th>
                        <td
                            style="cursor: pointer;"
                            class="text-left">
                            {{$role->name}}
                        </td>
                        <td scope="row">
                            <div class="text-left" style="overflow-y: scroll;
                            height: 100px;
                            padding-left: 10px;">
                            @foreach($permissions as $permission)
                                @if($role->id == $permission->roleId)
                                   - {{$permission->permissionName}} <br>
                                @endif
                            @endforeach
                            </div>
                        </td>
                        @hasrole('admin')
                        <td class="d-flex justify-content-center" scope="row">
                            <div>
                            <a href="{{url('users/role/edit').'/'.$role->id }}">
                                <button type="button" class="btn btn-primary mr-1 " data-toggle="modal" data-target="#user-form" >
                                    Sửa
                                </button>
                            </a>
                            </div>
                            @if($role->name !== 'admin')
                            <div >
                                <form method="post" action="{{url('users/role/destroy').'/'.$role->id }}">
                                    @csrf
                                    @method('DELETE')

                                    <button onClick="javascript: return confirm('Bạn chắc chứ ?');" class="btn btn-danger" type="submit">Xóa</button>

                                </form>
                            </div>
                            @endif
                        </td>
                        @endhasrole
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="display: block; margin-left: auto; margin-right: auto;width: 40%;">
            </div>
        </div>
    </div>
@endsection
