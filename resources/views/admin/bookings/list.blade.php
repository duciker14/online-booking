@extends('layouts.admin.master')
@section('title','List Booking')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List bookings</h6>
            </div>
            <div class="card-body">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <form action="{{route('list.booking')}}" method="get" id="filterForm">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Hotel:
                                                    <select name="hotel" class="form-control custom-select filterByHotel">
                                                        <option value="all" selected>All</option>
                                                        @foreach($hotels as $value)
                                                            <option value="{{$value->id}}" {{($value->id == $selectedHotel) ? 'selected' : ''}}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Status:
                                                    <select name="status" class="form-control custom-select filterByStatus">
                                                        <option value="all" selected>All</option>
                                                        @foreach($bookingStatus as $key => $value)
                                                            <option value="{{$value}}" {{((string)$value === $selectedStatus) ? 'selected' : ''}}>
                                                                {{ucfirst(strtolower($key))}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Checkin:
                                                <input type="date" name="checkin" class="form-control" value="{{$checkin}}">
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Checkout:
                                                    <input type="date" name="checkout" class="form-control" value="{{$checkout}}">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="listBooking" width="100%" cellspacing="0"
                                role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Hotel</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($bookings as $key => $item)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td><a href="{{route('users.show', $item->user->id)}}">{{ $item->user->name }}</a></td>
                                            <td><a href="{{ route('admin.hotel.show', $item->room->hotel->id) }}">{{ $item->room->hotel->name }}</a></td>
                                            <td><a href="mailto:{{ $item->user->email }}">{{ $item->user->email }}</a></td>
                                            <td><a href="tel:{{ $item->user->phone }}">{{ $item->user->phone }}</a></td>
                                            <td>{{ $item->getBookingStatusName() }}</td>
                                            <td>
                                                <a href="{{ route('detail.booking', $item->id) }}" class="btn btn-info"
                                                    title="Detail"><i class="fas fa-info-circle"></i></a>
                                                <a href="#" class="btn btn-danger" title="Delete"
                                                    data-toggle="modal" data-target="#deleteModal{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure want
                                                            to delete this?</h5>
                                                        <button class="close" type="button" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">Select "Delete" below if you are ready to
                                                        delete this.</div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-dismiss="modal">Cancel</button>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('delete.booking', $item->id) }}">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
@section('js')
    <script>
        jQuery(document).ready(function(e) {
            $('#listBooking').DataTable({
                searching: false, paging: false, info: false
            });
        });
    </script>
@endsection
@endsection
