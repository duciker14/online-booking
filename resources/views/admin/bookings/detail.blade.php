@extends('layouts.admin.master')
@section('title','Detail Booking')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800 text-center">Detail booking</h1>
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        <form class="user mb-4" action="{{ route('detail.booking', $booking->id) }}" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Customer Booking</label>
                    <div class="form-control">{{ $booking->user->name }}</div>
                </div>
                <div class="col-sm-6">
                    <label>Hotel</label>
                    <div class="form-control">{{ $booking->room->hotel->name }}</div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Email</label>
                    <div class="form-control"><a href="mailto:{{ $booking->user->email }}">{{ $booking->user->email }}</a></div>
                </div>
                <div class="col-sm-6">
                    <label>Phone</label>
                    <div class="form-control"><a href="tel:{{ $booking->user->phone }}">{{ $booking->user->phone }}</a></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Room Name</label>
                    <div class="form-control">{{ $booking->room->name }}</div>
                </div>
                <div class="col-sm-6">
                    <label>Total Price</label>
                    <div class="form-control">{{ number_format($booking->total, 2, ',', '.') }} $</div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Date Check In</label>
                    <div class="form-control">{{ $booking->check_in }}</div>
                </div>
                <div class="col-sm-6">
                    <label>Date Check Out</label>
                    <div class="form-control">{{ $booking->check_out }}</div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Status</label>
                    <div class="form-control">{{ $booking->getBookingStatusName() }}</div>
                </div>
                <div class="col-sm-6">
                    <label>Payment Status</label>
                    <div class="form-control">{{ $booking->getPaymentStatusName() }}</div>
                </div>
            </div>
            <div class="form-group">
                <label for="role">Note</label>
                <textarea name="note" rows="8" cols="50" class="form-control" disabled>{{ $booking->note }}</textarea>
            </div>
            {{-- <div class="text-center">
                <button type="submit" class="btn btn-primary btn-user">
                    Update Booking
                </button>
            </div> --}}
        </form>
    </div>
@endsection
