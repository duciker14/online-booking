@extends('layouts.admin.master')
@section('content')
<div class="container page-bank">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
            <h2 class="col-md-6 offset-md-3">Bank Account</h2>
                <div class="card-body">
                    @if (Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('message') }}
                    </div>
                    @endif
                    <form action="{{ route('manager.bank.update') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{auth()->user()->name}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Bank Name</label>
                            <input type="text" name="name" class="form-control" value="{{$bank->name ?? ''}}">
                        </div>
                        @error('name')
                        <div class="form-group">
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                        <div class="form-group">
                            <label>Bank Account Number</label>
                            <input type="text" name="code" class="form-control" value="{{$bank->code ?? ''}}">
                        </div>
                        @error('code')
                        <div class="form-group">
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                        <div class="form-group">
                            <label>Bank Branch</label>
                            <input type="text" name="branch" class="form-control" value="{{$bank->branch ?? ''}}">
                        </div>
                        @error('branch')
                        <div class="form-group">
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                        <button type="submit" name="update" class="btn btn-primary btn-user btn-block">Update</button>
                        <!-- <a href="{{ route('manager.dashboards.index')}}" class="btn btn-danger">Back</a> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection