@extends('layouts.admin.master')
@section('title','Detail Booking')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="background mb-3">
                    @php $bg = $booking->room->background ?? 'no_img.png'; @endphp
                        <img src="{{asset('img/hotel/'. $bg )}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title"><strong>Booking User: </strong> {{ $booking->user->name }}</h5>
                    <h5 class="card-title"><strong>Room: </strong> {{ $booking->room->name }}</h5>
                    <h5 class="card-title"><strong>Email: </strong><a href="mailto:{{ $booking->user->email }}">{{ $booking->user->email }}</a></h5>
                    <h5 class="card-title"><strong>Phone: </strong><a href="mailto:{{ $booking->user->phone }}">{{ $booking->user->phone }}</a></h5>
                    <h5 class="card-title"><strong>Check in: </strong> {{ $booking->check_in }}</h5>
                    <h5 class="card-title"><strong>Check out: </strong> {{ $booking->check_out }}</h5>
                    <h5 class="card-title"><strong>Total: </strong>{{ number_format( $booking->total, 1, ',', '.')}} $</h5>
                    <h5 class="card-title"><strong>Status: </strong>{{ $booking->getBookingStatusName() }}</h5>
                    <h5 class="card-title"><strong>Payment status: </strong> {{ $booking->getPaymentStatusName() }}</h5>
                    <h5 class="card-title"><strong>Note: </strong> {{ $booking->note ?? ''}}</h5>
                </div>
            </div>
            <div class="row ml-1 mt-2">
                <a href="{{ route('manager.bookings.index') }}" class="btn btn-danger">Back</a>
            </div>
        </div>
    </div>
@endsection
