@extends('partials.master')
@section('content')
    <div class="container-fluid">
        <div class="head-action row mb-5">
            <div class="col-2">
                <h4 class="">Quản lý permissions</h4>
            </div>
            <div class="col-4">
                <!-- Search user -->
                <form action="{{route('permission.index')}}?searchName=" enctype="multipart/form-data" method="GET">
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
                @hasrole('admin')
                <div class="d-flex justify-content-end align-items-center ">
                    <a href="{{route('permission.add')}}"><button type="button" class="btn btn-primary" >Thêm mới permission</button></a>
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
                    <th class="text-left" scope="col">Tên permission</th>
                    @hasrole('admin')
                    <th scope="col">Action</th>
                    @endhasrole
                </tr>
                </thead>
                <tbody>
                @if(!$permissions->isEmpty())
                @foreach($permissions as $key=>$permission )
                    <tr>
                    <th scope="row">{{$count++}}</th>
                    <td class="text-left">{{$permission->name}}</td>
                    @hasrole('admin')
                    <td class="d-flex justify-content-center" scope="row">
                        <div>
                            <a href="{{url('users/permission/edit').'/'.$permission->id}}"><button type="button" class="btn btn-primary mr-1 ">Sửa </button></a>
                        </div>
                        <div>
                            <form method="post" action="{{url('users/permission/destroy').'/'.$permission->id }}">
                                @csrf
                                @method('DELETE')

                                <button onClick="javascript: return confirm('Bạn chắc chứ ?');" class="btn btn-danger" type="submit">Xóa</button>

                            </form>
                        </div>
                    </td>
                    @endhasrole
                </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="3">No data ...</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div style="display: block; margin-left: auto; margin-right: auto;width: 40%;">
            </div>
        </div>
    </div>



@endsection
