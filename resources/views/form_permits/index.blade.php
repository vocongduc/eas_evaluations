@extends('partials.master')
@section('title')
    <title> Phân quyền Form </title>
@endsection
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include('vendor.flash.modal')
        <div class="head-action row mb-5">
            <div class="col-2">
                <h4 class="">Phân quyền đánh giá chéo </h4>
            </div>
            <div class="col-4">
                <!-- Search user -->
                <form action="{{route('formPermit.index')}}" method="get">
                    @csrf
                    <div class="input-group md-form form-sm form-2 pl-0 ">
                        <input class="form-control my-0 py-1 red-border" type="text" placeholder="Tìm kiếm" aria-label="Search" value="{{ $searchFormPermit }}" name="search_form_permit" id="search_form_permit">
                        <div class="input-group-append">
                            <button class="btn btn-info" ><i class="fas fa-search text-grey" aria-hidden="true"></i></button>  </div>
                    </div>
                </form>
            </div>
            <div class="col-6" style="padding-right: 100px;">
                <!-- add new user button -->
                <div class="d-flex justify-content-end align-items-center ">
                    <a href="{{route('formPermit.create')}}" class="create-modal"  title="Thêm phân quyền " style="text-decoration: none">
                        <button type="button" class="btn btn-success"> <i class="fas fa-plus" ></i> Thêm mới </button> </a>
                    <!-- Add new user form -->
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
                <th class="text-left">Tên khóa</th>
                <th class="text-left">Tên team</th>
                <th class="text-left">Tên thành viên</th>
                <th class="text-left">Danh sách form đánh giá</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            @if(!$listFormPermits->isEmpty())
                @php $i = ($listFormPermits->currentpage() - 1) * $listFormPermits->perpage() + 1; @endphp

            @foreach($listFormPermits as $formPermit)
            <tr>
                <td scope="row">{{ $i++ }}</td>
                <td class="text-left">{{ $formPermit->user['team']['course']['name'] }}</td>
                <td class="text-left">{{ $formPermit->user['team']['name'] }}</td>
                <td class="text-left"> {{ $formPermit->user['name'] }}</td>
                <td class="text-left">{{ $formPermit['form']['name'] }}</td>
                <td>
                    <a href="{{route('formPermit.show', $formPermit->id)}}" style="text-decoration: none">
                        <button type="button" class="btn btn-secondary"><i class="fa fa-eye" aria-hidden="true"></i></button>
                    </a>
                    <a href="{{route('formPermit.edit', $formPermit->id)}}" style="text-decoration: none">
                        <button type="button" class="btn btn-primary">  Sửa </button>
                    </a>
                    <form action="{{route('formPermit.destroy', $formPermit->id)}}" method="Post"  style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="btn btn-danger show_confirm" data-toggle="tooltip" data-target="#DeleteModal" title='Delete'>  Xóa </button>
                    </form>
                </td>

            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5" class="text-center"> Không có dữ liệu</td>
            </tr>
            @endif
            </tbody>
        </table>

        <!-- Pagination of mainpoint -->
                <div class="fa-pull-right" >
                    {{ $listFormPermits->links() }}
                </div>

    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
        $('.show_confirm').click(function(e) {
            if(!confirm('Bạn có chắc muốn xóa chứ ?')) {
                e.preventDefault();
            }
        });
    </script>
    <!-- /.container-fluid -->
@endsection


