@extends('layouts.admin.master')
@section('title','List Rooms')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LIST ROOMS</h6>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-8">
                    <form method="GET" class="formFilter">
                        <div class="row align-items-end">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Hotel:</label>
                                        <select name="hotel" class="form-control custom-select" id="">
                                            <option value="all">All</option>
                                            @foreach ($hotels as $key => $value )
                                                <option value="{{ $value->id }}" {{ ($value->id == request()->hotel) ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Room Type:</label>
                                        <select name="type" class="form-control custom-select" id="">
                                            <option value="all">All</option>
                                            @foreach ($roomType as $key => $value )
                                                <option value="{{ $value->id }}" {{ ($value->id == request()->type) ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Status:</label>
                                        <select name="status" class="form-control custom-select" id="">
                                            <option value="all">All</option>
                                            @foreach ($roomStatus as $key => $value )
                                                <option value="{{ $value }}" {{ ((string)$value == request()->status) ? 'selected' : '' }}>{{ ucfirst(strtolower($key)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-primary w-100" type="submit">
                                    <i class="fas fa-filter fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <label>Search:</label>
                    <form method="GET" class="">
                        <div class="input-group">
                            <input type="text" name="key" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>*</th>
                            <th>Hotel</th>
                            <th>Room Name</th>
                            <th>Room Type</th>
                            <th>Price ($)</th>
                            <th>Status</th>
                            <th>Acction</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><a href="{{route('admin.hotel.show', $room->hotel->id)}}">{{ $room->hotel->name }}</a></td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->roomType->name }}</td>
                            <td>{{ number_format($room->price, 2, ',', '.')}}</td>
                            <td>{{ $room->getRoomStatusName() }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('admin.rooms.edit', $room->id) }}"><i class="fas fa-info-circle"></i></a>
                                <a onclick = "return confirm('Want to delete?')" class="btn btn-danger" href="{{ route('admin.rooms.destroy', $room->id) }}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $rooms->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
    @if(session()->has('success'))
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

    @if(session()->has('error'))
        @section('js')
            <script>
                Toastify({
                text: "{{ session()->get('error') }}",
                style: {
                    background: "linear-gradient(to right, #b00008, #b53c52)",
                },
                duration: 3000
                }).showToast();
            </script>
        @endsection
    @endif

@section('js')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                searching: false, paging: false, info: false
            });
        });
    </script>
@endsection
