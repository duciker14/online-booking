@extends('layouts.home.master')
@section('title', 'History Booking')
@section('content')
<div class="page-detail-booking page">
    <div class="container">
        <h1 class="h3 mb-4 text-gray-800">Detail Booking</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hotel Name</label>
                            <div class="form-control">{{ $booking->room->hotel->name }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Room Name</label>
                            <div class="form-control">{{ $booking->room->name }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Check In</label>
                            <div class="form-control">{{ $booking->check_in }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Check Out</label>
                            <div class="form-control">{{ $booking->check_out }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <div class="form-control">{{ ucfirst(strtolower($status)) }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Payment Status</label>
                            <div class="form-control">{{ ucfirst(strtolower($paymentStatus)) }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Total</label>
                    <div class="form-control">{{ number_format($booking->total, 2, ',', '.') }} $</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
