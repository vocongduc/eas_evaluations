@extends('partials.master')

@section('title')
    <title> HyBrid-Technologies </title>
@endsection

@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper" style="margin-top: -80px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bản xem trước  </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <strong class="col-12 d-flex justify-content-center mb-4">
                        <p class="text-center" style="font-size: 30px; color: #3b5998; text-transform: uppercase">Đánh giá nhân viên 360</p>
                    </strong>
                    <div class="col-12">
                        <table class="table " style="width:30%">
                            <tbody>
                            @if (isset($formPermit))
                                <tr>
                                    <th scope="col">Họ tên</th>
                                    <td>{{ $formPermit->user->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Ngày hết hạn</th>
                                    <td>{{ \Carbon\Carbon::parse($formPermit->expired_date)->format('d/m/Y') }}</td>
                                </tr>
                            @else
                                <tr>
                                    <th scope="col">Họ tên</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="col">Ngày hết hạn</th>
                                    <td></td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <table class="table table-bordered text-center">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="width:15%"> Chuyên mục</th>
                                    <th scope="col" style="width:30%">Tiêu chí</th>
                                    <th scope="col" style="width:7.5%">Điểm</th>
                                    <th scope="col" colspan="2" style="width:15%">Bản thân đánh giá</th>
                                    <th scope="col" colspan="2" style="width:15%">Team đánh giá</th>
                                    <th scope="col" colspan="2" style="width:15%">Mentor đánh giá</th>
                                    <th scope="col" colspan="2" style="width:15%">Admin đánh giá</th>
                                </tr>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col" style="width:5%">Điểm</th>
                                    <th scope="col" style="width:5%">Tổng điểm</th>
                                    <th scope="col" style="width:5%">Điểm</th>
                                    <th scope="col" style="width:5%">Tổng điểm</th>
                                    <th scope="col" style="width:5%">Điểm</th>
                                    <th scope="col" style="width:5%">Tổng điểm</th>
                                    <th scope="col" style="width:5%">Điểm</th>
                                    <th scope="col" style="width:5%">Tổng điểm</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($forms as $mainPoint)
                                    <tr class=" table-active">
                                        <th class="text-danger" style="vertical-align: middle">
                                            <span style="text-transform: uppercase; font-weight: bold; font-size: 17px">{{$mainPoint['name']}}</span>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach($mainPoint['categories'] as $category)
                                        <tr>
                                            <th>{{$category['name']}}</th>
                                        @foreach($category['criterias'] as $criteria)
                                            <tr>
                                                <td></td>
                                                <td>
                                                    {{$criteria['name']}} <br>

                                                </td>
                                                <td>{{$criteria['point_weight']}}</td>

                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('forms.index') }}">
                    <input type="submit" class="btn btn-secondary" value="Đóng">
                </a>
            </div>
        </div>
    </div>
@endsection

