@extends('layouts.admin.master')
@section('title','Detail Request Payment')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800 text-center">Detail payment request</h1>
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        <form class="user mb-4" action="{{ route('detail.payment.request', $paymentRequest->id) }}" method="post">
            @csrf
            <div class="form-group">
                <label>Customer Name</label>
                <div class="form-control btn-secondary">{{ $paymentRequest->user->name }}</div>
            </div>
            <div class="form-group">
                <label>Money</label>
                <div class="form-control btn-secondary">{{ number_format($paymentRequest->amount, 2, ',', '.') }} $</div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Date Request</label>
                    <div class="form-control btn-secondary">{{ $paymentRequest->request_date }}</div>
                </div>
                <div class="col-sm-6">
                    <label>Date Payment</label>
                    <div class="form-control btn-secondary">{{ $paymentRequest->payment_date }}</div>
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="custom-select" disabled>
                    @foreach ($status as $key => $value)
                        <option value="{{ $value }}" {{ $value == $paymentRequest->status ? 'selected' : '' }}>
                            {{ ucfirst(strtolower($key)) }}</option>
                    @endforeach
                </select>
                @error('status')
                    <div class="form-group">
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="role">Reject Cause</label>
                <textarea name="reject_cause" rows="8" cols="50" class="form-control @error('reject_cause') is-invalid @enderror" disabled>{{ $paymentRequest->reject_cause }}</textarea>
            </div>
            {{-- <div class="text-center">
                <button type="submit" class="btn btn-primary btn-user">
                    Update Payment Request
                </button>
            </div> --}}
        </form>
    </div>
@endsection
