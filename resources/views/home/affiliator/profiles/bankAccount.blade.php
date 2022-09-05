@extends('layouts.home.master')
@section('title', 'Bank Account')
@section('content')

<div class="page">
    <div class="black-color mt-5 pd-5 container page-bank">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h4>
                        <h3 class="text-center">BANK MY ACCOUNT</h3>
                        <div class="card-body">
                            @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                            @endif
                            <form action="{{ route('affiliator.bank.update') }}" method="post">
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
                                <div class="mt-4 text-right">
                                    <button type="submit" name="update" class="btn btn-info float-end">Update</button>
                                    <!-- <a href="{{ route('manager.dashboards.index')}}" class="btn btn-danger">Back</a> -->
                                </div>
                            </form>
                        </div>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection