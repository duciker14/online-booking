@extends('layouts.admin.master')
@section('content')
    <div class="container-fluid">
        <div class="text-center">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Change your password</h1>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    @if (Session::has('cpw'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('cpw') }}
                        </div>
                    @endif
                    <form class="user" action="{{ route('change.password') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="password"
                                class="form-control form-control-user @error('current_password') is-invalid @enderror"
                                name="current_password" placeholder="Current Password">
                        </div>
                        @error('current_password')
                            <div class="form-group">
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror
                        <div class="form-group">
                            <input type="password"
                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                id="exampleInputPassword" placeholder="Password" name="password">
                        </div>
                        @error('password')
                            <div class="form-group">
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror
                        <div class="form-group">
                            <input type="password"
                                class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                                id="exampleRepeatPassword" placeholder="Repeat Password" name="password_confirmation">
                        </div>
                        @error('password_confirmation')
                            <div class="form-group">
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
