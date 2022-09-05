@extends('layouts.admin.master')
@section('title','Detail - '.$room->name)
@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3 text-center">
        <h1>Room Name: {{$room->name}}</h1>
    </div>
    <div class="card-body">
        @php $bg = $room->background ?? 'no_img.png'; @endphp
        <div class="row">
            <div class="col-md-6">
                <div class="background mb-3">
                    <img src="{{asset('img/rooms/'. $bg )}}">
                </div>
            </div>
            <div class="col-md-6">
                <p><b>Room type:</b> {{$room->roomType->name}}</p>
                <p><b>Price:</b> {{$room->price}}</p>
                <p><b>Status:</b> {{$room->getRoomStatusName()}}</p>
                @if($room->status == \App\Enums\RoomStatus::BOOKING)
                    <p><b>Booking user:</b> {{$room->booking->user->name}}</p>
                    <p><b>Email user:</b><a href="mailto:{{ $room->booking->user->email }}"> {{$room->booking->user->email}}</a> </p>
                    <p><b>Phone user:</b><a href="tel:{{ $room->booking->user->phone }}"> {{$room->booking->user->phone}}</a> </p>
                @endif
                <p><b>Description:</b> {{$room->description}}</p>
                @if($room->img) 
                    <div class="list-img">
                        @foreach(json_decode($room->img) as $key => $value)
                            <div class="item">
                                <img src="{{ asset('img/rooms/'.$value) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        $('.list-img').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            autoplay: true,
            autoplaySpeed: 2000,
            prevArrow: '<div class="slick-prev"><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="slick-next"><i class="fa fa-chevron-right"></i></div>'
        });
    </script>
@endsection
