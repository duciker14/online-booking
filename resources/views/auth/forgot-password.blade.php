@extends('layouts.auth.master')
@section('title', 'Forgot Password')
@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-body pt-0">
                            <h3 class="text-center mt-4">
                                <a href="index.html" class="logo logo-admin"><img width="32%" height="50%" src="{{ asset('img/logo.png') }}"
                                    alt="logo"></a>
                            </h3>
                            <div class="p-3">
                                <h4 class="text-muted font-size-18 mb-1 text-center">Forgot Your Password?</h4>
                                <p class="text-muted text-center">We get it, stuff happens. Just enter your email address
                                    below and we'll send you a link to reset your password!</p>
                                @if (Session::has('message'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('message') }}
                                    </div>
                                @endif
                                <form class="form-horizontal mt-4" action="{{ route('forgot.password') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            placeholder="Enter email">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="submit" name="sub-login"
                                            class="btn btn-primary w-md waves-effect waves-light" value="Reset Password">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
