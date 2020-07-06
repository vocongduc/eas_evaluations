@extends('partials.master')
@section('content')
    <div class="container-fluid">
        <div class="head-action row mb-5">
            <div class="col-2">
                <h4 class="">Quản lý user</h4>
            </div>
            <div class="col-4">
                <!-- Search user -->
                <form action="{{route('users.index')}}?searchName=" enctype="multipart/form-data" method="GET">
                    @csrf
                    <div class="input-group md-form form-sm form-2 pl-0 ">
                        <input class="form-control my-0 py-1 red-border" value="{{$search}}" type="text" name="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="input-group-text red lighten-3"
                                    type="submit" id="basic-text1">
                                <i class="fas fa-search text-grey" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <!-- add new user button -->
                <div class="d-flex justify-content-end align-items-center ">
                    @hasrole('admin')
                    <a href="{{route('users.add')}}"><button type="button" class="btn btn-primary" >Thêm mới user</button></a>
                    <!-- Add new user form -->
                    @endhasrole
                </div>
            </div>
        </div>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('err'))
            <div class="alert alert-danger">
                {{ session()->get('err') }}
            </div>
        @endif
        <div class="table-responsive-sm table-responsive-md table-small-custom ">
            <table class="table table-hover mb-5 text-center">
                <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th class="text-left" scope="col">Họ và Tên</th>
                    <th scope="col" class="text-left">Email</th>
                    <th scope="col">Avatar</th>
                    <th scope="col" class="text-left">Address</th>
                    <th scope="col"  class="text-left">Team</th>
                    <th scope="col"  class="text-left">Roles</th>
                    @hasrole('admin')
                    <th scope="col" >Action</th>
                    @endhasrole
                </tr>
                </thead>
                <tbody>
                @if(!$users->isEmpty())
                @foreach($users as $key=>$user)

                <tr>
                    <th scope="row">{{$count++}}</th>
                    <td class="text-left">{{ $user->user_name}} <i style="color: palevioletred">{{auth()->user()->name == $user->user_name ?' (Me)': ''}}</i></td>
                    <td class="text-left">{{$user->email}}</td>
                    <td><img src="{{$user->image}}" width="80px" height="50px" alt="img_err"></td>
                    <td class="text-left">{{$user->address}}</td>
                    <td class="text-left">{{$user->team_name}}</td>
                    <td class="text-left">{{$user->role_name}}</td>
                    <td class="d-flex justify-content-center" scope="row">
                        @hasrole('admin')
                        @if($user->role_name !== 'admin')
                        <div>
                            <a href="{{url('users/edit').'/'.$user->id}}" style="text-decoration: none"><button type="button" class="btn btn-primary mr-1 " >Sửa </button></a>
                        </div>
                        <div>
                            <form method="post" action="{{url('users/destroy').'/'.$user->id }}">
                                @csrf
                                @method('DELETE')

                                <button onClick="javascript: return confirm('Bạn chắc chứ ?');" class="btn btn-danger" type="submit">Xóa</button>

                            </form>
                        </div>
                        @endif
                        @endhasrole
                    </td>
                </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center"><b>No Data ...</b></td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="fa-pull-right">
                {{ $users->links() }}
            </div>
        </div>
    </div>



@endsection
