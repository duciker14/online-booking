@extends('layouts.admin.master')
@section('title','Detail Hotels')
@section('content')



<div class="card shadow mb-4">
    <div class="card-header py-3 text-center">
        <h1>{{$hotel->name}}</h1>
        <span class="hotel-rating"></span>
    </div>
    <div class="card-body">
        @php $bg = $hotel->background ?? 'no_img.png'; @endphp
        <div class="row">
            <div class="col-md-6">
                <div class="background mb-3">
                    <img src="{{asset('img/hotel/'. $bg )}}">
                </div>
            </div>
            <div class="col-md-6">
                <p><b>Manager:</b> {{$hotel->user->name}}</p>
                <p><b>Hotline:</b> <a href="tel:{{$hotel->hotline}}">{{$hotel->hotline}}</a></p>
                <p><b>Email:</b> <a href="mailto:{{$hotel->user->email}}">{{$hotel->user->email}}</a></p>
                <p><b>Address:</b> {{$hotel->address}}</p>
                @foreach($roomType as $key => $value)
                    <p><b>Room Type {{$key}}:</b> {{ count($value)}} room</p>
                @endforeach
                <p><b>Total room:</b> {{ count($hotel->rooms)}} room</p>
                <p><b>Total booking:</b> {{ $booking }} booking</p>
                <p><b>Number of reviews:</b> {{ count($hotel->reviews)}} reviews</p>
                <p><b>Description:</b> {{$hotel->description}}</p>
            </div>
        </div>
    </div>
</div>
@php $reviews = $hotel->reviews; @endphp
@if(count($reviews) > 0)
<div class="card shadow">
    <div class="card-header py-3">
        <h2 class="mb-0">List Reviews</h2>
    </div>
    <div class="card-body">
        <div class="container">
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="list-review">
                @foreach($reviews as $review)
                <div class="item">
                    <a class="btn btn-danger btn-delete" href="{{ route('delete.reviews', $review->id) }}"><i class="fa fa-trash"></i></a>
                    <div class="avatar">
                        @php $avt = $review->user->avatar ?? 'avatar.png';  @endphp
                        <img src="{{  asset('img/users/'.$avt)}}" alt="">
                    </div>
                    <div class="info">
                        <h4 class="name">
                            <a href="#">{{$review->user->name}}</a>
                            <span class="date-review">{{ \Carbon\Carbon::parse($review->created_at)->format('H:i:s d-m-Y') }}</span>
                        </h4>
                        <div class="star mb-3">
                            <span class="user-rating{{$review->id}}"></span>
                        </div>
                        <div class="description">
                            {!! $review->content !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
@section('js')
<script>
    jQuery(document).ready(function() {
        $('.list-img').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            autoplay: true,
            autoplaySpeed: 2000,
            prevArrow: '<div class="slick-prev"><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="slick-next"><i class="fa fa-chevron-right"></i></div>'
        });

        $(".hotel-rating").starRating({
            readOnly: true,
            initialRating: "{{ $star }}"
        });

        @foreach($hotel->reviews as $review)
            $('.user-rating{{$review->id}}').starRating({
                readOnly: true,
                initialRating: "{{ $review->rate }}",
                starSize: 25
            });
        @endforeach

    })
</script>
@endsection
@endsection
