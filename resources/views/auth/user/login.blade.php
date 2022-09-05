@extends('layouts.auth.master')
@section('title', 'Login')
@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="card-body pt-0">
                        <h3 class="text-center mt-4">
                            <a href="#" class="logo logo-admin"><img width="32%" height="50%" src="{{ asset('img/logo.png') }}"
                                    alt="logo"></a>
                        </h3>
                        <div class="p-3">
                            @if (session('succRegis'))
                                <div class="alert alert-success">
                                    {{ session('succRegis') }}
                                </div>
                            @endif
                            @if (Session::has('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            <form class="form-horizontal mt-4" action="{{ route('user.sublogin') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" @if(Cookie::has('adminmail')) value="{{ Cookie::get('adminmail') }}" @endif  id="email" placeholder="Enter email">
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" @if(Cookie::has('adminpwd')) value="{{ Cookie::get('adminpwd') }}" @endif id="password" placeholder="Enter password">
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <div class="form-group row mt-4">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember_me" @if(Cookie::has('adminmail')) checked @endif class="custom-control-input" id="customControlInline">
                                            <label class="custom-control-label" for="customControlInline">Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <input type="submit" name="sub-login" class="btn btn-primary w-md waves-effect waves-light" value="Log In">
                                    </div>
                                </div>
                                <div class="form-group mb-0 row">
                                    <div class="col-12 mt-4">
                                        <a href="{{ route('forgot.password') }}" class="text-primary"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                     <a href="{{ route('google.login') }}" class="btn btn-danger btn-user btn-block">
                        <i class="fab fa-google-f fa-fw"></i>
                        <strong>G</strong> Login with Google <strong>G</strong>
                     </a>
                    <p>Don't have an account ? <a href="{{ route('register') }}" class="text-primary"> Signup Now </a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
