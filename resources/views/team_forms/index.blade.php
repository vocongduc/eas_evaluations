@extends('partials.master')
@section('title')
    <title> Phân quyền Form </title>
@endsection
@section('content')
    @include('vendor.flash.modal')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="head-action row mb-5">
            <div class="col-2">
                <h4 class="">Phân quyền đánh giá Form </h4>
            </div>
            <div class="col-4">
                <!-- Search user -->
                <form action="{{route('teamForm.index')}}" method="get">
                    @csrf
                    <div class="input-group md-form form-sm form-2 pl-0 ">
                        <input class="form-control my-0 py-1 red-border" type="text" value="{{$search}}" placeholder="Tìm kiếm" aria-label="Search" name="search_team_form">
                        <div class="input-group-append">
                            <button class="btn btn-info" ><i class="fas fa-search text-grey" aria-hidden="true"></i></button>  </div>
                    </div>
                </form>
            </div>
            <div class="col-6" style="padding-right: 100px;">
                <!-- add new user button -->
                <div class="d-flex justify-content-end align-items-center ">
                    <a href="{{route('teamForm.create')}}" class="create-modal"  title="Thêm phân quyền " >
                        <button type="button" class="btn btn-success"> <i class="fas fa-plus" ></i> Thêm mới </button> </a>
                    <!-- Add new user form -->
                </div>
            </div>
        </div>
        <div class="col-12">
            @include('flash::message')
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
                <th class="text-left">Tên Khóa Học </th>
                <th>Tên Team </th>
                <th>Tên form được phân quyền  </th>
                <th>Ngày hết hạn</th>
                <th>Hành động </th>

            </tr>
            </thead>
            <tbody>
            @if(!$listTeamForms->isEmpty())
                @foreach($listTeamForms as  $listTeamForm)

                    <tr>
                        <td scope="row">{{ $count++ }}</td>

                        <td class="text-left">
                            @foreach($listCourses as $item)

                                @if($item->id == $listTeamForm->team['course_id'])
                                    {{ $item->name}}
                                @endif
                            @endforeach
                        </td>

                        <td class="text-left">
                                {{$listTeamForm->team['name']}}
                        </td>
                        <td class="text-left">
                            {{$listTeamForm->form['name']}}
                        </td>
                        <td class="text-left">{{ \Carbon\Carbon::parse($listTeamForm->expired_date)->format('d/m/Y') }}<td>
                            <a href="{{route('teamForm.edit',$listTeamForm->id)}}" style="text-decoration: none" >
                                <button type="button" class="btn btn-primary">  Sửa </button>
                            </a>
                            <form action="{{route('teamForm.destroy',$listTeamForm->id)}}" method="Post"  style="display: inline-block" method="POST">
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
                    <td colspan="6" class="text-center"> Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>

        <!-- Pagination of mainpoint -->
        <div class="fa-pull-right" >
            {!! $listTeamForms->render() !!}
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


