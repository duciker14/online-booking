@extends('layouts.admin.master')
@section('title','Create Booking')
@section('content')


<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 text-center">Add booking</h1>
    @if (Session::has('status'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('status') }}
    </div>
    @endif
    <form class="user mb-4" action="{{route('manager.bookings.add.booking')}}" method="post">
        @csrf
        @method('POST')
        <!-- <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label>Customer Booking</label>
                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
            </div>
            <div class="col-sm-6">
                <label>Hotel</label>
                <input type="text" class="form-control" value="{{ $hotel->name }}" disabled>
            </div>
        </div> -->
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label>Room Name</label>
                <select name="room" id="room" class="form-control custom-select">
                    <option selected>-- Choose room --</option>
                    @foreach($rooms as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('room')
                    <div class="form-group">
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror
            </div>
            <div class="col-sm-6">
                <label>Price</label>
                <input type="text" class="form-control" id="price" name="price" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Check In</label>
                    <input class="form-control" type="datetime-local" name="check_in">
                </div>
                @error('check_in')
                    <div class="form-group">
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Check out</label>
                    <input class="form-control" type="datetime-local" name="check_out">
                </div>
                @error('check_out')
                    <div class="form-group">
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="role">Note</label>
            <textarea name="note" rows="8" cols="50" class="form-control @error('note') is-invalid @enderror"></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-user">
                Add Booking
            </button>
        </div>
    </form>
</div>
@section('js')
    <script>
        jQuery(document).ready(function(e) {
            $('#room').on('change', function() {
                let roomId = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('manager.bookings.ajax.price.room') }}",
                    datatype: "text",
                    data: {
                        _token: '{{ csrf_token() }}',
                        roomId: roomId,
                    },
                    success: function(data) {
                        $('#price').val(data);
                    },
                });
            });
        });
    </script>
@endsection

@endsection
