@extends('partials.master')

@section('title')
    <title> HyBrid-Technologies </title>
@endsection

@section('content')
    <!-- Modal -->
    <div class="container-fluid">

        <div class="head-action row mb-5">
            <div class="col-6">
                <h4 class="">Cập nhật thông tin cá nhân</h4>
            </div>

        </div>
            <div class="modal-body">
                    <form action="{{ url('/profile/edit', $profile->id) }}" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group row">
                            <label for="avatar" class="col-sm-2 col-form-label small">Avatar</label>
                            <div class="col-sm-10">
                                <div id="wrapp-avt-img">
                                    @if ($profile->image == '')
                                        <img class="img-profile rounded-circle" name="image" src="{{ asset('img/images.jpeg') }}" alt="avatar" width="50px">
                                    @else
                                        <img class="img-profile rounded-circle" name="image" src="{{ asset($profile->image) }}" alt="avatar" width="50px">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Tải lên</label>
                                    <input type="file" name="image" class="form-control-file" id="image" onchange='openFile(event)'>
                                    @error('image')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Họ và tên</label>
                            <div class="col-sm-10 {{ $errors->has('name') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="name" name="name" value="{{ isset($profile) ? ($errors->has('name') ? old('name') : $profile->name) :old('name') }}">
                                @error('name')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10 {{ $errors->has('email') ? 'has-error' : '' }}">
                                <input type="text" class="form-control"  value="{{ isset($profile) ? ($errors->has('email') ? old('email') : $profile->email) :old('email') }}" disabled>
                                <input type="hidden" id="email" name="email" value="{{ isset($profile) ? ($errors->has('email') ? old('email') : $profile->email) :old('email') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Địa chỉ</label>
                            <div class="col-sm-10 {{ $errors->has('address') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="address" name="address" value="{{ isset($profile) ? ($errors->has('address') ? old('address') : $profile->address) :old('address')}}">
                                @error('address')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Ngày sinh</label>
                            <div class="col-sm-10 {{ $errors->has('birth_day') ? 'has-error' : '' }}">
                                <input type="date" class="form-control" id="birth_day" name="birth_day" value="{{ isset($profile) ? ($errors->has('birth_day') ? old('birth_day') : $profile->birth_day) :old('birth_day')}}">
                                @error('birth_day')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="numberPhone" class="col-sm-2 col-form-label">Số điện thoại</label>
                            <div class="col-sm-10 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ isset($profile) ? ($errors->has('phone') ? old('phone') : $profile->phone) :old('phone')}}">
                                @error('phone')
                                     <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Mật khẩu</label>
                            <div class="col-sm-10 {{ $errors->has('password') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu">
                                @error('password')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Xác Nhận Mật khẩu</label>
                            <div class="col-sm-10 {{ $errors->has('password_confirm') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Nhập lại mật khẩu">
                                @error('password_confirm')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="modal-footer" style="width: 100%">
                                <a href="{{ route('home') }}">
                                    <input type="button" name="submit" value="Đóng" class="btn btn-secondary btn-action" data-dismiss="modal">
                                </a>
                                <button class="btn btn-danger">Lưu</button>
                            </div>
                        </div>
                        <input type="hidden" name="redirect_url" value="{{ old('redirect_url') ?? (url()->previous()) }} ">
                    </form>
                </div>
    </div>
    <script>
        var openFile = function(event) {
            var input = event.target;

            var reader = new FileReader();
            reader.onload = function(){
                TheFileContents = reader.result;
                document.getElementById("wrapp-avt-img").innerHTML = '<img width="50px" class="img-profile rounded-circle"" src="'+TheFileContents+'" />';
            };
            reader.readAsDataURL(input.files[0]);
        };
    </script>
@endsection
