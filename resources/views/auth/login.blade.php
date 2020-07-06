<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body class="bg-gradient-primary background-login">
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center" >
        <div class="col-xl-6 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5 ">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <img src="{{ asset('/img/logo-blue.png') }}" alt="" width="400px">
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <label for="" style="font-weight: bold;color: #000000;">Email</label>
                                    <div class="form-group">
                                        <input type="email" style="border-color: black" class="form-control form-control-user @error('email') is-invalid @enderror"
                                               id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email..." name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong style="font-size: 14px; color: #ff0000">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="" style="font-weight: bold;color: #000000;">Mật khẩu</label>
                                    <div class="form-group">
                                        <input type="password" style="border-color: black"  class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Mật khẩu"
                                               name="password" required autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox"  class="custom-control-input" name="remember" id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customCheck" style="color: black">Nhớ mật khẩu</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex align-items-center flex-column">
                                        <div class="g-recaptcha" data-sitekey="6Leq2awZAAAAADsr81zawEU7sa656TRxVzx7LADK"></div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" style="display: block; text-align:center">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <input type="submit" class="btn btn-primary btn-user" value="Đăng Nhập">
                                    </div>
                                </form>
                                <hr>
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        <a class="small" href="{{ route('password.request') }}">
                                            {{ __('Quên mật khẩu?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
@include('layouts.script')
</body>
</html>
