@extends('layouts.home.master')
@section('title', 'Booking')
@section('content')
<div class="page">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form class="black-color user mb-4" action="{{route('user.subBooking', $room->id)}}" method="post">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <h4 class="text-center w-100"><b>Hotel: {{ $room->hotel->name }}</b></h4>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label>Room Name</label>
                            <input type="text" class="form-control" value="{{ $room->name }}" name="name_room" readonly>
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
                            <input type="text" class="form-control" value="{{ $room->price }}" name="price" readonly>
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
                            Booking
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection
