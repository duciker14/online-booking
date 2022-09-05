@extends('layouts.home.master')
@section('title','Result Page')
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
<div class="intro">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="intro_title text-center">Result hotels</h2>
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
        @foreach ($result as $rate )
            <div class="col-lg-4 intro_col mb-4">
                <div class="intro_item">
                    <div class="intro_item_overlay"></div>
                    <!-- Image by https://unsplash.com/@dnevozhai -->
                    <div class="intro_item_background" style="background-image:url({{asset('img/hotel/'.$rate['background'])}})"></div>
                    <div class="intro_item_content d-flex flex-column align-items-center justify-content-center">
                        <div class="intro_date">Top Hotel</div>
                        <div class="button intro_button"><div class="button_bcg"></div><a href="{{route('detail-hotel',$rate['id'])}}">see more<span></span><span></span><span></span></a></div>
                        <div class="intro_center text-center">
                            <h1>{{$rate['name']}}</h1>
                            <div class="intro_price">{{$rate['address']}}</div>
                            <div class="rating rating_4">
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
        <div class="d-flex justify-content-center"> {{$result->links()}}</div>
    </div>
</div>
@endsection
