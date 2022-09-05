@extends('layouts.home.master')
@section('title', 'History Booking')
@section('content')
<div class="page-history-booking page">
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">History Booking</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered dataTable" id="listBooking" width="100%" cellspacing="0"
                                    role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>Hotel</th>
                                            <th>Room</th>
                                            <th>Checkin</th>
                                            <th>Checkout</th>
                                            <th>Total ($)</th>
                                            <th>Status</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($bookings as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td><a href="{{route('detail-hotel',$item->room->hotel->id)}}">{{ $item->room->hotel->name }}</a></td>
                                                <td>{{ $item->room->name }}</td>
                                                <td>{{ $item->check_in }}</td>
                                                <td>{{ $item->check_out }}</td>
                                                <td>{{ number_format($item->total, 2, ',', '.') }}</td>
                                                <td>{{ $item->getBookingStatusName() }}</td>
                                                <td>
                                                    <a href="{{ route('user.detail-booking', $item->id) }}" class="btn btn-info"
                                                        title="Detail"><i class="fa fa-info-circle"></i></a>
                                                    @if($item->status == App\Enums\BookingStatus::SCHEDULE && $item->payment_status == App\Enums\PayStatus::UNPAID)
                                                    <a href="{{ route('user.cancel-booking', $item->id) }}" class="btn btn-danger" title="Cancel">
                                                        <i class="fa fa-times-circle"></i>
                                                    </a>
                                                    @endif
                                                    @if($item->status == App\Enums\BookingStatus::DELIVERY && $item->payment_status == App\Enums\PayStatus::PAID)
                                                    <a href="{{ route('user.refund-booking', $item->id) }}" class="btn btn-primary" title="Refund">
                                                        <i class="fa fa-undo"></i>
                                                    </a>
                                                    @endif
                                                    @if($item->status == App\Enums\BookingStatus::SCHEDULE && $item->payment_status == App\Enums\PayStatus::UNPAID)
                                                    <a href="{{ route('user.payment-booking', $item->id) }}" class="btn btn-success" title="Payment">
                                                        <i class="fa fa-check-circle"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-between">
                            <div class="dataTables_info">Showing {{($bookings->currentpage()-1)*$bookings->perpage()+1}} to {{(($bookings->currentpage()-1)*$bookings->perpage())+$bookings->count()}} of {{$bookings->total()}} entries</div>
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@if(session()->has('success'))
    @section('js')
        <script>
            Toastify({
            text: "{{ session()->get('success') }}",
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            duration: 5000
            }).showToast();
        </script>
    @endsection
@endif

@if(session()->has('error'))
    @section('js')
        <script>
            Toastify({
            text: "{{ session()->get('error') }}",
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            duration: 3000
            }).showToast();
        </script>
    @endsection
@endif
@endsection
