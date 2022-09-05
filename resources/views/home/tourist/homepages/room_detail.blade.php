@extends('layouts.home.master')
@section('title','Detail Room - '.$room->name)
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/single_listing_responsive.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/single_listing_styles.css')}}">
@endsection
@section('content')
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="single_listing">
                    <!-- Hotel Info -->

                    <div class="hotel_info">

                        <!-- Title -->
                        <div class="hotel_title_container d-flex flex-lg-row flex-column">
                            <div class="hotel_title_content">
                                <h1 class="hotel_title">{{$room->name}}</h1>
                                <div class="room_price">${{$room->price}}/night</div>
                                {{-- <div class="rating_r rating_r_{{round($star)}} hotel_rating">
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                </div> --}}
                                <div class="hotel_location">{{$room->hotel->address}}</div>
                            </div>
                            @if($room->status == \App\Enums\RoomStatus::AVAILABLE)
                            <div class="hotel_title_button ml-lg-auto text-lg-right">
                                <div class="button book_button trans_200"><a href="{{ route('user.booking', ['id_hotel' => $room->hotel_id, 'id_room' => $room->id]) }}">book<span></span><span></span><span></span></a></div>
                                <div class="hotel_map_link_container">
                                    {{-- <div class="hotel_map_link">See Location on Map</div> --}}
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Listing Image -->

                        <div class="hotel_image">
                            @if ($room->background != null)
                                <img src="{{asset('img/rooms/'.$room->background)}}" alt="">
                            @else
                                <img src="{{asset('img/no_img.jpg')}}" alt="">
                            @endif

                            <div class="hotel_review_container d-flex flex-column align-items-center justify-content-center">
                                <div class="hotel_review">
                                    <div class="hotel_review_content">
                                        <div class="hotel_review_title">very good</div>
                                        <div class="hotel_review_subtitle">100 reviews</div>
                                    </div>
                                    <div class="hotel_review_rating text-center">5</div>
                                </div>
                            </div>
                        </div>

                        <!-- Hotel Gallery -->

                        <div class="hotel_gallery">
                            <div class="hotel_slider_container">
                                <div class="owl-carousel owl-theme hotel_slider">
                                    @if ($room->img != null)
                                        @if (isset($arr['hinh1']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh1'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh1'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh1']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh1'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh1'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh2']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh2'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh2'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh3']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh3'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh3'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh4']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh4'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh4'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh5']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh5'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh5'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh6']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh6'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh6'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh7']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh7'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh7'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh8']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh8'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh8'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh9']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh9'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh9'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh10']))
                                        <!-- rooms Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/rooms/'.$arr['hinh10'])}}">
                                                <img src="{{asset('img/rooms/'.$arr['hinh10'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                    @else
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="">
                                                <img src="{{asset('img/no_img.png')}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Hotel Slider Nav - Prev -->
                                <div class="hotel_slider_nav hotel_slider_prev">
                                    <svg version="1.1" id="Layer_6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        width="28px" height="33px" viewBox="0 0 28 33" enable-background="new 0 0 28 33" xml:space="preserve">
                                        <defs>
                                            <linearGradient id='hotel_grad_prev'>
                                                <stop offset='0%' stop-color='#fa9e1b'/>
                                                <stop offset='100%' stop-color='#8d4fff'/>
                                            </linearGradient>
                                        </defs>
                                        <path class="nav_path" fill="#F3F6F9" d="M19,0H9C4.029,0,0,4.029,0,9v15c0,4.971,4.029,9,9,9h10c4.97,0,9-4.029,9-9V9C28,4.029,23.97,0,19,0z
                                        M26,23.091C26,27.459,22.545,31,18.285,31H9.714C5.454,31,2,27.459,2,23.091V9.909C2,5.541,5.454,2,9.714,2h8.571
                                        C22.545,2,26,5.541,26,9.909V23.091z"/>
                                        <polygon class="nav_arrow" fill="#F3F6F9" points="15.044,22.222 16.377,20.888 12.374,16.885 16.377,12.882 15.044,11.55 9.708,16.885 11.04,18.219
                                        11.042,18.219 "/>
                                    </svg>
                                </div>

                                <!-- Hotel Slider Nav - Next -->
                                <div class="hotel_slider_nav hotel_slider_next">
                                    <svg version="1.1" id="Layer_7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    width="28px" height="33px" viewBox="0 0 28 33" enable-background="new 0 0 28 33" xml:space="preserve">
                                        <defs>
                                            <linearGradient id='hotel_grad_next'>
                                                <stop offset='0%' stop-color='#fa9e1b'/>
                                                <stop offset='100%' stop-color='#8d4fff'/>
                                            </linearGradient>
                                        </defs>
                                    <path class="nav_path" fill="#F3F6F9" d="M19,0H9C4.029,0,0,4.029,0,9v15c0,4.971,4.029,9,9,9h10c4.97,0,9-4.029,9-9V9C28,4.029,23.97,0,19,0z
                                    M26,23.091C26,27.459,22.545,31,18.285,31H9.714C5.454,31,2,27.459,2,23.091V9.909C2,5.541,5.454,2,9.714,2h8.571
                                    C22.545,2,26,5.541,26,9.909V23.091z"/>
                                    <polygon class="nav_arrow" fill="#F3F6F9" points="13.044,11.551 11.71,12.885 15.714,16.888 11.71,20.891 13.044,22.224 18.379,16.888 17.048,15.554
                                    17.046,15.554 "/>
                                    </svg>
                                </div>

                            </div>
                        </div>

                        <!-- Hotel Info Text -->

                        <div class="hotel_info_text">
                            <p>{{$room->hotel->description}}</p>
                        </div>

                        <!-- Hotel Info Tags -->

                        <div class="hotel_info_tags">
                            <ul class="hotel_icons_list">
                                <li class="hotel_icons_item"><img src="images/post.png" alt=""></li>
                                <li class="hotel_icons_item"><img src="images/compass.png" alt=""></li>
                                <li class="hotel_icons_item"><img src="images/bicycle.png" alt=""></li>
                                <li class="hotel_icons_item"><img src="images/sailboat.png" alt=""></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
