@extends('layouts.home.master')
@if(!isset($req))
@section('title', 'Request Payment')
@else
@section('title', 'Edit Request')
@endif
@section('content')
<div class="page black-color">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Request withdrawal: ${{ number_format($affiliator->money, 0, '', '.') }}</h4>
                            <a class="btn btn-info" href="{{ route('user.request-history') }}">Request History</a>
                        </div>

                        <div class="card" style="width: 21rem;">
                            <div class="card-body">
                                @if(!isset($req))
                                    <form action="{{ route('user.subRequestPayment') }}" method="post">
                                @else
                                    <form action="{{ route('user.update-request',$req->id) }}" method="post">
                                @endif
                                    @csrf
                                    <div class="form-group">
                                        @if(!isset($req))
                                            <label>Press money</label>
                                            <input type="number" class="form-control"name="money" placeholder="Money number...">
                                        @else
                                            <label>Edit request money</label>
                                            <input type="number" class="form-control"name="money" value="{{$req->amount}}" placeholder="Money number...">
                                        @endif
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="submit" class="btn btn-primary" value="submit" name="submit">
                                    </div>
                                </form>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>

                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
