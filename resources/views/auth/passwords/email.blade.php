<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body class="bg-gradient-primary">
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <img src="{{ asset('/img/hybrid-logo-gray.png') }}" alt=""
                                         width="300px">
                                    <div class="line"
                                         style="width: 85%;height: 1px; border-bottom: 2px solid black;margin:2rem 2rem 2rem 2rem;"></div>
                                    <h1 class="h4 text-gray-900 mb-4" style="margin-top: 2rem;font-weight: bold;">Reset Password</h1>
                                </div>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form class="user" method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <label for="" style="font-weight: bold;color: #000000;">{{ __('E-Mail Address') }}</label>
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <a href="{{ route('login') }}" style="text-decoration: none;">
                                            <input type="button" class="btn btn-dark btn-user" value="Quay Lại">
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-user">
                                            {{ __('Send Password Reset') }}
                                        </button>
                                    </div>
                                </form>
                                <hr>
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
