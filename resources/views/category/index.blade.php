@extends('partials.master')
@section('title')
    <title> Quản lý Danh mục </title>
@endsection
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="head-action row mb-5">
            <div class="col-2">
                <h4 class="">Quản lý Danh mục</h4>
            </div>
            <div class="col-4">
                <!-- Search user -->
                <form action="{{route('categories.index')}}" method="get">
                    <div class="input-group md-form form-sm form-2 pl-0 ">
                        <input class="form-control my-0 py-1 red-border" type="text" placeholder="Tìm kiếm" aria-label="Search" name="search_cate">
                        <div class="input-group-append">
                            <button class="btn btn-info" ><i class="fas fa-search text-grey" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6" style="padding-right: 100px;">
                <!-- add new user button -->
                <div class="d-flex justify-content-end align-items-center ">
                    <a href="{{route('categories.create')}}" class="create-modal"  title="Thêm Danh mục" >
                        <button type="button" class="btn btn-success"> <i class="fas fa-plus" ></i> Thêm mới </button> </a>
                </div>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {!! session('error') !!}
            </div>
        @endif
        <!-- Mainpoint list -->
        <table class="table table-hover mb-5" >
            <thead >
            <tr>
                <th>STT</th>
                <th class="text-left">Tên danh mục </th>
                <th>Tên mainpoint</th>
                <th>Độ ưu tiên</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if(!$categories->isEmpty())
            @foreach($categories as $key => $cate)
                <tr>
                    <td scope="row">{{$cate->id}}</td>
                    <td class="text-left">{{$cate->name}}</td>
                    <td class="text-left">{{$cate->Mainpoint['name']}}</td>
                    <td class="text-left">{{$cate->priority}}</td>
                    <td>
                        <a href="{{route('categories.edit',$cate->id)}}" style="text-decoration: none">
                            <button type="button" class="btn btn-primary mr-1"> Sửa</button>
                        </a>
                        <form action="{{route('categories.destroy',[$cate->id]) }}" method="Post" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" data-target="#DeleteModal" title='Delete'>  Xóa </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                <td colspan="6" class="text-center"> Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>

        <div class="fa-pull-right" >
            {{ $categories->links() }}
        </div>

    </div>

    <!-- /.container-fluid -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
        $('.show_confirm').click(function(e) {
            if(!confirm('Bạn có chắc muốn xóa chứ ?')) {
                e.preventDefault();
            }
        });
    </script>

@endsection

