@extends('layouts.admin.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail</h6>
                </div>
                <div class="card-body">
                    @php $bg = $room->background ?? 'no_img.png';  @endphp
                    <div class="background mb-3">
                    <img class="card-img-top" src="{{ asset('img/rooms/'.$bg) }}" alt="Card image cap">
                    </div>
                    <h5 class="card-title"><strong>Name:</strong> {{ $room->name }}</h5>
                    <h5 class="card-title"><strong>Manager:</strong> {{ $room->hotel->user->name }}</h5>
                    <h5 class="card-title"><strong>Hotel:</strong> {{ $room->hotel->name }}</h5>
                    <h5 class="card-title"><strong>Price:</strong> {{ number_format($room->price, 2, ',', '.')}} $</h5>
                    @if($room->img)
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="card-title"><strong>Images:</strong></h5>
                            @foreach (json_decode($room->img, true) as $image)
                                <img width="auto" height="100px" src="{{ asset('img/rooms/'.$image) }}" alt="Card image cap" class="mb-1">
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="row ml-1 mt-2">
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection