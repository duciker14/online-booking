@extends('layouts.home.master')
@section('title','Yourhotel247 - More than just a place to stay')
@section('slide')
	<div class="home">

		<!-- Home Slider -->
		<div class="home_slider_container">

			<div class="owl-carousel owl-theme home_slider">

				@foreach ( $slide_list as $slide )
					<!-- Slider Item -->
					<div class="owl-item home_slider_item">
						<!-- Image by https://unsplash.com/@anikindimitry -->
						@if ($slide->background == null)
							<div class="home_slider_background" style="background-image:url({{asset('img/hotel/home_slider.jpg')}})"></div>
						@else
							<div class="home_slider_background" style="background-image:url({{asset('img/hotel/'.$slide->background)}})"></div>
						@endif
						<div class="home_slider_content text-center">
							<div class="home_slider_content_inner" data-animation-in="flipInX" data-animation-out="animate-out fadeOut">
								<h1>{{$slide->name}}</h1>
								{{-- <h1>HUE CITY</h1> --}}
								<div class="button home_slider_button"><div class="button_bcg"></div><a href="{{route('detail-hotel',$slide->id)}}">see more<span></span><span></span><span></span></a></div>
							</div>
						</div>
					</div>

				@endforeach
			</div>

			<!-- Home Slider Nav - Prev -->
			<div class="home_slider_nav home_slider_prev">
				<svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					width="28px" height="33px" viewBox="0 0 28 33" enable-background="new 0 0 28 33" xml:space="preserve">
					<defs>
						<linearGradient id='home_grad_prev'>
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

			<!-- Home Slider Nav - Next -->
			<div class="home_slider_nav home_slider_next">
				<svg version="1.1" id="Layer_3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				width="28px" height="33px" viewBox="0 0 28 33" enable-background="new 0 0 28 33" xml:space="preserve">
					<defs>
						<linearGradient id='home_grad_next'>
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

			<!-- Home Slider Dots -->


		</div>
	</div>
@endsection
@section('content')

	<div class="search">


		<!-- Search Contents -->

		<div class="container fill_height">
			<div class="row fill_height">
				<div class="col fill_height">

					<!-- Search Tabs -->

					<!-- Search Panel -->

					<div class="search_panel active">
						<form action="{{route('search_hotel')}}" id="search_form_1" class="search_panel_content d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-between justify-content-start">
							<div class="search_item">
								<div>Please enter a name or a address</div>
								<input type="text" name="hotel" id="timkiem" class="destination search_input col-sm-12" required="required">
                                <ul class="list-group" id="result" >
                                </ul>
							</div>
							<button class="button search_button">search<span></span><span></span><span></span></button>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- Những KS có đánh giá cao nhất -->

	<div class="intro">
		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="intro_title text-center">We have list best hotels</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="intro_text text-center">
						{{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu convallis tortor. Suspendisse potenti. In faucibus massa arcu, vitae cursus mi hendrerit nec. </p> --}}
					</div>
				</div>
			</div>
			<div class="row intro_items">

				<!-- Intro Item -->
            @foreach ($arr as $rate )
                <div class="col-lg-4 intro_col">
                    <div class="intro_item">
                        <div class="intro_item_overlay"></div>
                        @php $bg = $rate['background'] ?? 'no_img.png'; @endphp
                        <div class="intro_item_background" style="background-image:url({{asset('img/hotel/'.$bg)}})"></div>
                        <div class="intro_item_content d-flex flex-column align-items-center justify-content-center">
                            <div class="intro_date">Top Hotel</div>
                            <div class="button intro_button"><div class="button_bcg"></div><a href="{{route('detail-hotel',$rate['id'])}}">see more<span></span><span></span><span></span></a></div>
                            <div class="intro_center text-center">
                                <h1>{{$rate['name']}}</h1>
                                <div class="intro_price">{{$rate['address']}}</div>
                                <div class="rating rating_{{$rate['rate']}}">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

			</div>
		</div>
	</div>

	<!-- CTA -->
    <div class="trending">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<h2 class="section_title">new hotels</h2>
				</div>
			</div>
			<div class="row trending_container">
                @foreach ($trending as $new_hotel)
                    <!-- Trending Item -->
				<div class="col-lg-3 col-sm-6">
					<div class="trending_item clearfix">
						@if ($new_hotel->background != null)
                            <div class="trending_image"><img src="{{asset('img/hotel/'.$new_hotel->background)}}" alt=""></div>
                        @else
                            <div class="trending_image"><img src="{{asset('img/no_img.jpg')}}" alt=""></div>
                        @endif
						<div class="trending_content">
							<div class="trending_title"><a href="{{route('detail-hotel',$new_hotel['id'])}}">{{$new_hotel->name}}</a></div>
							{{-- <div class="trending_price">{{$new_hotel->users->name}}</div> --}}
							<div class="trending_location">{{$new_hotel->address}}</div>
						</div>
                        </div>
                    </div>
                @endforeach


			</div>
		</div>
	</div>




	<!-- Những bài đánh giá tốt nhất từ KH -->

	<div class="testimonials">
		<div class="test_border"></div>
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<h2 class="section_title">List of tourist reviews</h2>
				</div>
			</div>
			<div class="row">
				<div class="col">

					<!-- Testimonials Slider -->

					<div class="test_slider_container">
						<div class="owl-carousel owl-theme test_slider">
                            <!-- Testimonial Item -->
                                @foreach ( $list_review as $rv )
                                    <div class="owl-item">
                                        <div class="test_item">
                                            @php $avatar =  $rv->user->avatar ?? 'avatar.png' @endphp
                                            <div class="test_image"><img src="{{asset('img/users/'.$avatar)}}" alt="https://unsplash.com/@anniegray"></div>
                                            <div class="test_icon"><img src="{{asset('img/backpack.png')}}" alt=""></div>
                                            <div class="test_content_container">
                                                <div class="test_content">
                                                    <div class="test_item_info">
                                                        <div class="test_name">{{$rv->user->name}}</div>
                                                        <div class="test_date">{{$rv->created_at}}</div>
                                                    </div>
                                                    <div class="test_quote_title">{{$rv->hotel->name}}</div>
                                                    <p class="test_quote_text">{{$rv->content}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

						</div>

						<!-- Testimonials Slider Nav - Prev -->
						<div class="test_slider_nav test_slider_prev">
							<svg version="1.1" id="Layer_6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								width="28px" height="33px" viewBox="0 0 28 33" enable-background="new 0 0 28 33" xml:space="preserve">
								<defs>
									<linearGradient id='test_grad_prev'>
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

						<!-- Testimonials Slider Nav - Next -->
						<div class="test_slider_nav test_slider_next">
							<svg version="1.1" id="Layer_7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="28px" height="33px" viewBox="0 0 28 33" enable-background="new 0 0 28 33" xml:space="preserve">
								<defs>
									<linearGradient id='test_grad_next'>
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
			</div>

		</div>
	</div>



<!--Những bài viết từ các KS -->
@if(count($posts) > 0)
<div class="offers">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h2 class="section_title">List posts of Hotels</h2>
            </div>
        </div>
        <div class="row offers_items">
            @foreach ($posts as $post)
            <div class="col-lg-6 offers_col">
                <div class="offers_item">
                    <div class="offers_image_container">
                        @php $img = $post->image ?? 'no_img.jpg'; @endphp
                        <img src="{{asset('img/'.$img)}}" alt="">
                        <div class="offer_name"><a href="#">grand castle</a></div>
                    </div>
                    <div class="offers_content">
                        <div class="offers_title">{{ $post->title }}</div>
                        <p class="offers_text">{!! $post->content !!}</p>
                        <div class="offers_link"><a href="#">read more</a></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection
