@extends('layouts.auth.master')
@section('title', 'Register')
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
                            <h4 class="text-muted font-size-18 mb-1 text-center">Free Register</h4>
                            <p class="text-muted text-center">Get your free Lexa account now.</p>
                            <form class="form-horizontal mt-4" action="{{ route('add.user') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input type="text" class="form-control" value="" name="name" id="name" placeholder="Enter username">
                                    @error('username')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="useremail">Email</label>
                                    <input type="email" class="form-control" value="" name="email" id="email" placeholder="Enter email">
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter password">
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- <div class="form-group">
                                    <label for="userpassword">Re-Password</label>
                                    <input type="password" class="form-control" name="re-password" placeholder="Enter Re-password">
                                    @error('re-password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div> -->

                                <div class="form-group">
                                    <label for="birthday">Birthday</label>
                                    <input type="date" class="form-control" name="birthdate">
                                    @error('birthday')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Phone number</label>
                                    <input type="" class="form-control" value="" name="phone" placeholder="Enter phone numner">
                                    @error('phone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Gender:&emsp; </label>
                                    <input type="radio" class="" name="gender" value="0" checked> Male &emsp;
                                    <input type="radio" class="" name="gender" value="1"> Female &emsp;
                                    @error('gender')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea type="text" class="form-control" value="" name="address" placeholder="Enter address"></textarea>
                                    @error('address')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Become An Affiliator </label>
                                    <input type="checkbox" name="affiliator" value="">
                                </div>

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="form-group row mt-4">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button>
                                    </div>
                                </div>
                                <div class="form-group mb-0 row">
                                    <div class="col-12 mt-4">
                                        <p class="text-muted mb-0 font-size-14">By registering you agree to the Lexa <a href="" onclick="return false;" class="text-primary">Terms of Use</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>Already have an account ? <a href="{{ route('user.login') }}" class="text-primary"> Login </a> </p>
                    <p>© 2018 - 2020 Lexa. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection