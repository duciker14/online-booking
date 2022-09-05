@extends('layouts.home.master')
@section('title','About Page')
@section('css')
<link rel="stylesheet" type="text/css" href="css/about_styles.css">
<link rel="stylesheet" type="text/css" href="css/about_responsive.css">
@endsection
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
<!-- Intro -->

<div class="intro">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="intro_image"><img src="{{asset('img/intro.png')}}" alt=""></div>
            </div>
            <div class="col-lg-5">
                <div class="intro_content">
                    <div class="intro_title">we have the best tours</div>
                    <p class="intro_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus quis vulputate eros, iaculis consequat nisl. Nunc et suscipit urna. Integer elementum orci eu vehicula pretium. Donec bibendum tristique condimentum. Aenean in lacus ligula. Phasellus euismod gravida eros. Aenean nec ipsum aliquet, pharetra magna id, interdum sapien. Etiam id lorem eu nisl pellentesque semper. Nullam tincidunt metus placerat, suscipit leo ut, tempus nulla. Fusce at eleifend tellus. Ut eleifend dui nunc, non fermentum quam placerat non. Etiam venenatis nibh augue, sed eleifend justo tristique eu</p>
                    {{-- <div class="button intro_button"><div class="button_bcg"></div><a href="#">explore now<span></span><span></span><span></span></a></div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->

<div class="stats">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title">years statistics</div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 offset-lg-1 text-center">
                <p class="stats_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus quis vulputate eros, iaculis consequat nisl. Nunc et suscipit urna. Integer elementum orci eu vehicula pretium. Donec bibendum tristique condimentum. Aenean in lacus ligula. </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="stats_years">
                    <div class="stats_years_last">2021</div>
                    <div class="stats_years_new float-right">2022</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="stats_contents">

                    <!-- Stats Item -->
                    <div class="stats_item d-flex flex-md-row flex-column clearfix">
                        <div class="stats_last order-md-1 order-3">
                            <div class="stats_last_icon d-flex flex-column align-items-center justify-content-end">
                                <img src="images/stats_1.png" alt="">
                            </div>
                            <div class="stats_last_content">
                                <div class="stats_number">1642</div>
                                <div class="stats_type">Clients</div>
                            </div>
                        </div>
                        <div class="stats_bar order-md-2 order-2" data-x="1642" data-y="3527" data-color="#31124b">
                            <div class="stats_bar_perc">
                                <div>
                                    <div class="stats_bar_value"></div>
                                </div>
                            </div>
                        </div>
                        <div class="stats_new order-md-3 order-1 text-right">
                            <div class="stats_new_icon d-flex flex-column align-items-center justify-content-end">
                                <img src="images/stats_1.png" alt="">
                            </div>
                            <div class="stats_new_content">
                                <div class="stats_number">3527</div>
                                <div class="stats_type">Clients</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Item -->
                    <div class="stats_item d-flex flex-md-row flex-column clearfix">
                        <div class="stats_last order-md-1 order-3">
                            <div class="stats_last_icon d-flex flex-column align-items-center justify-content-end">
                                <img src="images/stats_2.png" alt="">
                            </div>
                            <div class="stats_last_content">
                                <div class="stats_number">768</div>
                                <div class="stats_type">Returning Clients</div>
                            </div>
                        </div>
                        <div class="stats_bar order-md-2 order-2" data-x="768" data-y="145" data-color="#a95ce4">
                            <div class="stats_bar_perc">
                                <div>
                                    <div class="stats_bar_value"></div>
                                </div>
                            </div>
                        </div>
                        <div class="stats_new order-md-3 order-1 text-right">
                            <div class="stats_new_icon d-flex flex-column align-items-center justify-content-end">
                                <img src="images/stats_2.png" alt="">
                            </div>
                            <div class="stats_new_content">
                                <div class="stats_number">145</div>
                                <div class="stats_type">Returning Clients</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Item -->
                    <div class="stats_item d-flex flex-md-row flex-column clearfix">
                        <div class="stats_last order-md-1 order-3">
                            <div class="stats_last_icon d-flex flex-column align-items-center justify-content-end">
                                <img src="images/stats_3.png" alt="">
                            </div>
                            <div class="stats_last_content">
                                <div class="stats_number">11546</div>
                                <div class="stats_type">Reach</div>
                            </div>
                        </div>
                        <div class="stats_bar order-md-2 order-2" data-x="11546" data-y="9321" data-color="#fa6f1b">
                            <div class="stats_bar_perc">
                                <div>
                                    <div class="stats_bar_value"></div>
                                </div>
                            </div>
                        </div>
                        <div class="stats_new order-md-3 order-1 text-right">
                            <div class="stats_new_icon d-flex flex-column align-items-center justify-content-end">
                                <img src="images/stats_3.png" alt="">
                            </div>
                            <div class="stats_new_content">
                                <div class="stats_number">9321</div>
                                <div class="stats_type">Reach</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Item -->
                    <div class="stats_item d-flex flex-md-row flex-column clearfix">
                        <div class="stats_last order-md-1 order-3">
                            <div class="stats_last_icon d-flex flex-column align-items-center justify-content-end">
                                <img src="images/stats_4.png" alt="">
                            </div>
                            <div class="stats_last_content">
                                <div class="stats_number">3729</div>
                                <div class="stats_type">Items</div>
                            </div>
                        </div>
                        <div class="stats_bar order-md-2 order-2" data-x="3729" data-y="17429" data-color="#fa9e1b">
                            <div class="stats_bar_perc">
                                <div>
                                    <div class="stats_bar_value"></div>
                                </div>
                            </div>
                        </div>
                        <div class="stats_new order-md-3 order-1 text-right">
                            <div class="stats_new_icon d-flex flex-column align-items-center justify-content-end">
                                <img src="images/stats_4.png" alt="">
                            </div>
                            <div class="stats_new_content">
                                <div class="stats_number">17429</div>
                                <div class="stats_type">More Items</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add --

@endsection
