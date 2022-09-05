@extends('layouts.home.master')
@section('title','Detail - '.$hotel->name)
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/single_listing_responsive.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/single_listing_styles.css')}}">
@endsection
@section('content')
<div class="page">
    <div class="container ">
        <div class="row">
            <div class="col-lg-12">
                <div class="single_listing">

                    <!-- Hotel Info -->

                    <div class="hotel_info">

                        <!-- Title -->
                        <div class="hotel_title_container d-flex flex-lg-row flex-column">
                            <div class="hotel_title_content">
                                <h1 class="hotel_title">{{$hotel->name}}</h1>
                                {{-- <div class="rating_r rating_r_{{round($star)}} hotel_rating">
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                </div> --}}
                                <div class="hotel_location">{{$hotel->address}}</div>
                            </div>
                            <div class="hotel_title_button ml-lg-auto text-lg-right">
                                {{-- <div class="button book_button trans_200"><a href="#">bo2ok<span></span><span></span><span></span></a></div> --}}
                                <div class="hotel_map_link_container">
                                    {{-- <div class="hotel_map_link">See Location on Map</div> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Listing Image -->

                        <div class="hotel_image">
                            @if ($hotel->background != null)
                                <img src="{{asset('img/hotel/'.$hotel->background)}}" alt="">
                            @else
                                <img src="{{asset('img/no_img.jpg')}}" alt="">
                            @endif

                            <div class="hotel_review_container d-flex flex-column align-items-center justify-content-center">
                                <div class="hotel_review">
                                    <div class="hotel_review_content">
                                        <div class="hotel_review_title">
                                            @if ($star < 3 )
                                                Bad
                                            @elseif ($star <= 4)
                                                Good
                                            @else
                                                Very Good
                                        @endif
                                        </div>
                                        <div class="hotel_review_subtitle">{{$count_review}} reviews</div>
                                    </div>
                                    <div class="hotel_review_rating text-center">{{round($star)}}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Hotel Gallery -->

                        <div class="hotel_gallery">
                            <div class="hotel_slider_container">
                                <div class="owl-carousel owl-theme hotel_slider">
                                    @if ($hotel->images != null)
                                        @if (isset($arr['hinh1']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh1'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh1'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh1']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh1'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh1'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh2']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh2'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh2'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh3']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh3'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh3'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh4']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh4'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh4'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh5']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh5'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh5'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh6']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh6'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh6'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh7']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh7'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh7'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh8']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh8'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh8'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh9']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh9'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh9'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                        @if (isset($arr['hinh10']))
                                        <!-- Hotel Gallery Slider Item -->
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/hotel/'.$arr['hinh10'])}}">
                                                <img src="{{asset('img/hotel/'.$arr['hinh10'])}}" alt="https://unsplash.com/@jbriscoe">
                                            </a>
                                        </div>
                                        @endif
                                    @else
                                        <div class="owl-item">
                                            <a class="colorbox cboxElement" href="{{asset('img/no_img.png')}}">
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
                            <p>{{$hotel->description}}</p>
                        </div>

                        <!-- Hotel Info Tags -->

                        {{-- <div class="hotel_info_tags">
                            <ul class="hotel_icons_list">
                                <li class="hotel_icons_item"><img src="images/post.png" alt=""></li>
                                <li class="hotel_icons_item"><img src="images/compass.png" alt=""></li>
                                <li class="hotel_icons_item"><img src="images/bicycle.png" alt=""></li>
                                <li class="hotel_icons_item"><img src="images/sailboat.png" alt=""></li>
                            </ul>
                        </div> --}}

                    </div>

                    <!-- Rooms -->

                    <div class="rooms">
                        @foreach ($list_room as $room)
                             <!-- Room -->
                            <div class="room">

                                <!-- Room -->
                                <div class="row">
                                    <div class="col-lg-2">
                                        @if ($room->background != null)
                                            <div class="room_image"><img src="{{asset('img/rooms/'.$room->background)}}" alt="https://unsplash.com/@oowgnuj"></div>
                                        @else
                                            <div class="room_image"><img src="{{asset('img/rooms/anh2.jpg')}}" alt="https://unsplash.com/@oowgnuj"></div>
                                        @endif
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="room_content">
                                            <div class="room_title">Room: {{$room->name}}</div>
                                            <div class="room_price">${{$room->price}}/night</div>
                                            <div class="room_text">{{$room->description}}</div>
                                            <div class="room_extra">{{$room->status==0?'AVAILABLE':'BOOKING'}}</div>
                                        </div>
                                    </div>
                                    @if($room->status == \App\Enums\RoomStatus::AVAILABLE)
                                    <div class="col-lg-3 text-lg-right">
                                        <div class="room_button">
                                            <div class="button book_button trans_200"><a href="{{route('detail-room',['id_hotel' => $hotel->id, 'id_room' => $room->id])}}">detail<span></span><span></span><span></span></a></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        @endforeach
                    </div>

                    <!-- Reviews -->

                    <div class="reviews">
                        <div class="reviews_title">reviews</div>
                        <div class="reviews_container">
                            @foreach ($review as $rev )
                                 <!-- Review -->
                                <div class="review">
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <div class="review_image">
                                                @if ($rev->user->avatar != null)
                                                    <img src="{{asset('img/users/'.$rev->user->avatar)}}" alt="https://unsplash.com/@saaout">
                                                @else
                                                    <img src="{{asset('img/users/avatar.png')}}" alt="https://unsplash.com/@saaout">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-11">
                                            <div class="review_content">
                                                <div class="review_title_container">
                                                    <div class="review_title">"{{$rev->user->name}}"</div>
                                                    <div class="review_rating">{{$rev->rate}}</div>
                                                </div>
                                                <div class="review_text">
                                                    <p>{{$rev->content}}</p>
                                                </div>
                                                {{-- <div class="review_name">Christinne Smith</div> --}}
                                                <div class="review_date">{{$rev->created_at}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            @endforeach

                        </div>
                    </div>
                    @if (auth()->check())
                    <div class="contact mt-5" style="background-image:url({{asset('img/contact.png')}})">
                        <div class="row no-gutters">
                            <div class="col-lg-5">
                                <div class="contact_image">

                                </div>
                            </div>
                                <div class="col-lg-7">
                                    <div class="contact_form_container">
                                        <div class="contact_title">Reviews</div>
                                            <ul class="list-inline" style="display: flex" title="Average Rating">
                                                @for ($count=1;$count <= 5; $count++)
                                                    @php
                                                        if($detail_rate != null){
                                                            if ($count <= $detail_rate->rate) {
                                                                $color = 'color:#ffcc00';
                                                            }else{
                                                                $color = 'color:#ccc';
                                                            }
                                                        }

                                                    @endphp
                                                        @if($detail_rate != null)
                                                            <li title="rate-star" id="{{$hotel->id}}-{{Auth::user()->id}}-{{$count}}" data-index="{{$count}}" data-hotel_id="{{$hotel->id}}"  data-user_id="{{Auth::user()->id}}" data-rating="{{$detail_rate->rate}}" class="rating" style="cursor: pointer; {{$color}}; font-size:30px;">
                                                                &#9733;
                                                            </li>
                                                        @else
                                                            <li title="rate-star" id="{{$hotel->id}}-{{Auth::user()->id}}-{{$count}}" data-index="{{$count}}" data-hotel_id="{{$hotel->id}}"  data-user_id="{{Auth::user()->id}}" data-rating="0" class="rating" style="cursor: pointer; color:#ccc; font-size:30px;">
                                                                &#9733;
                                                            </li>
                                                        @endif
                                                @endfor
                                            </ul>
                                        <form action="{{route('update-content')}}" method="POST" id="contact_form" class="contact_form">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                            <textarea id="contact_form_message" class="text_field contact_form_message" name="content" rows="4" placeholder="Message" required="required" data-error="Please, write us a message."></textarea>
                                            <button type="submit" id="form_submit_button" class="form_submit_button button">Send Reviews<span></span><span></span><span></span></button>
                                        </form>
                                        @if($detail_rate != null)
                                            <form action="{{route('destroy-reviews',$detail_rate->id)}}" method="post" id="contact_form" class="contact_form">
                                                {{ csrf_field() }}
                                                <button type="submit" id="form_submit_button" class="form_submit_button button" style="background: red">You have reviewed this hotel, Do you want to delete it?<span></span><span></span><span></span></button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <a href="{{url('/login')}}" class="text-center d-block">Vui lòng đăng nhập để đánh giá</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
