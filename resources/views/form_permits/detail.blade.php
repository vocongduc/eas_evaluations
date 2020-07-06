@extends('partials.master')
@section('title')
    <title> Hybrid </title>
@endsection
@section('content')
    <center>
        <h3>Chi tiết quyền đánh giá của <b style="color: #0E0EFF">{{$user->name}}</b></h3>
    </center>
    <a href="{{route('formPermit.index')}}" style="margin-left: 92%">
        <button type="button" class="btn btn-secondary ">Trở lại</button>
    </a>
    <br><br>
    <div class="form-group row container-fluid">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Người được đánh giá</th>
                <th scope="col">Người đánh giá</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$user->name}}</td>
                    <td>
                        <div class="list-group">
                            <ul class="list-group">
                                @foreach($allData as $evaluateUser)
                                    @if(!empty($evaluateUser))
                                    <li class="list-group-item">{{$evaluateUser->eva_name}}
                                        <i style="color: red">{{$evaluateUser->role_name}}</i>
                                    </li>
                                    @else
                                        Không có dữ liệu ...
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
@stop
