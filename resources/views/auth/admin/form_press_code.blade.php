@extends('layouts.auth.master')
@section('title', 'Login')
@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="card-body pt-0">
                        <div class="p-3">
                            <h4 class="text-muted font-size-18 mb-1 text-center">Please check mail to get code!</h4>

                            <form class="form-horizontal mt-4" action="{{ route('auth.sub-verify-admin') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="number" class="form-control" name="verification_code" placeholder="Ex: 123456">
                                </div>
                                <div class="form-group text-center">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                                @if (Session::has('error'))
                                    <div class="alert alert-danger" style="color: red">
                                        {{ Session::get('error') }}
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
