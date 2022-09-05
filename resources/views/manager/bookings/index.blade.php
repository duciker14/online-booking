@extends('layouts.admin.master')
@section('title','List Bookings')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LIST MANAGER</h6>
        </div>
        <div class="card-body">
            <div class="">
                <form method="GET" id="filterForm" class="mb-3">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Search for all:
                                        <div class="input-group">
                                            <input type="text" name="key"
                                                class="form-control" placeholder="Search for..."
                                                aria-label="Search" aria-describedby="basic-addon2">
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Status:
                                        <select name="status" class="form-control custom-select filterByStatus">
                                            <option value="" selected>All</option>

                                            @foreach ($bookingStatus as $key => $value)
                                                <option value="{{ $key }}">
                                                    {{ ucfirst(strtolower($key)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Check in:
                                        <input type="date" name="check_in"
                                            class="form-control" />
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Check out:
                                        <input type="date" name="check_out"
                                            class="form-control" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <label for="" class="w-100">
                                <button class="btn btn-primary w-100" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </label>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered" id="tablehotel" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Room</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            {{-- <th>Payment Status</th> --}}
                            <th class="text-right">Acction</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $key => $booking)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->room->name }}</td>
                                <td><a href="mailto:{{ $booking->user->email }}">{{ $booking->user->email }}</a></td>
                                <td><a href="tel:{{ $booking->user->phone }}">{{ $booking->user->phone }}</a></td>
                                <td>{{ $booking->getBookingStatusName() }}</td>
                                {{-- <td>{{ $booking->getPaymentStatusName() }}</td> --}}
                                <td>
                                    <a class="btn btn-info" href="{{ route('manager.bookings.edit', $booking->id) }}"><i
                                            class="fas fa-info-circle"></i></a>
                                    @if(($booking->status == $bookingStatus['CANCEL']) || ($booking->status == $bookingStatus['DONE']) || ($booking->status == $bookingStatus['SCHEDULE'] && $booking->payment_status == $paymentStatus['UNPAID']))
                                    <a onclick="return confirm('Want to delete?')" class="btn btn-danger"
                                        href="{{ route('manager.bookings.destroy', $booking->id) }}"><i
                                            class="fas fa-trash"></i></a>
                                    @endif
                                    @if($booking->status == $bookingStatus['SCHEDULE'] && $booking->payment_status == $paymentStatus['UNPAID'])
                                    <a class="btn btn-danger" href="" title="cancel" data-toggle="modal"
                                        data-target="#deleteModal{{ $booking->id }}"><i
                                            class="fas fa-times-circle"></i></a>
                                    @endif
                                    @if($booking->payment_status == $paymentStatus['WAIT_ACCEPT'])
                                        <button class="btn btn-success confirm-payment" data-id="{{ $booking->id }}" title="Confirm Payment"><i
                                            class="fas fa-check-circle"></i></button>
                                    @endif
                                    @if($booking->status == $bookingStatus['REFUND'])
                                    <form class="d-inline" action="{{ route('manager.bookings.refund', $booking->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-warning refund" data-id="{{ $booking->id }}" title="Refund"><i
                                            class="fas fa-undo"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="deleteModal{{ $booking->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Cancel cause</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('manager.bookings.reject', $booking->id) }}"
                                                method="post">
                                                @csrf
                                                <textarea class="form-control" name="cancel_cause" cols="30" rows="5"></textarea>
                                                <div class="modal-footer justify-content-center">
                                                    <a class="btn btn-info" type="button" data-dismiss="modal">Cancel</a>
                                                    <button class="btn btn-primary reject" type="submit"
                                                        name="update">Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <div class="dataTables_info">Showing {{ ($bookings->currentpage() - 1) * $bookings->perpage() + 1 }} to
                    {{ ($bookings->currentpage() - 1) * $bookings->perpage() + $bookings->count() }} of
                    {{ $bookings->total() }} entries</div>
                {{ $bookings->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
@endsection

@if (session()->has('success'))
    @section('js')
        <script>
            Toastify({
                text: "{{ session()->get('success') }}",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                duration: 3000
            }).showToast();
        </script>
    @endsection
@endif

@if (session()->has('error'))
    @section('js')
        <script>
            Toastify({
                text: "{{ session()->get('error') }}",
                style: {
                    background: "linear-gradient(45deg, #eb6b6b, #b5292900)",
                },
                duration: 3000
            }).showToast();
        </script>
    @endsection
@endif

@section('js')
    <script>
        jQuery(document).ready(function() {
            $('.confirm-payment').each(function() {
                $(this).on('click', function() {
                    let _this = $(this);
                        id = $(this).attr('data-id');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('manager.bookings.confirm.payment') }}",
                        datatype: "text",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                        },
                        success: function(data) {
                            _this.remove();
                            Toastify({
                                text: data,
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                duration: 3000
                            }).showToast();
                            window.location.reload();
                        }
                    });
                });
            })

        });
    </script>
@endsection
