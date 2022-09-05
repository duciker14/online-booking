<!DOCTYPE html>
<html lang="en">
<head>
<title>@yield('title')</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Travelix Project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
<link href="{{asset('plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/OwlCarousel2-2.2.1/owl.theme.default.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/OwlCarousel2-2.2.1/animate.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('css/main_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}">
<link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" >
@yield('css')
</head>

<body>

<div class="super_container">

	<!-- Header -->

	<header class="header">

		<!-- Top Bar -->

		<div class="top_bar">
			<div class="container">
				<div class="row">
					<div class="col d-flex flex-row">
						<div class="phone">+84 355 787 951</div>
						<div class="social">
							<ul class="social_list">
								<li class="social_list_item"><a href="https://www.facebook.com/duc1ker"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							</ul>
						</div>
						@auth
						<div class="user_box ml-auto">
                            <div class="user_box_login user_box_link dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    @if(auth()->user()->role == \App\Enums\UserRole::TOURIST)
                                        <a class="dropdown-item" href="{{ route('tourist.profile') }}">
                                            <i class="fa fa-user"></i>
                                            Profile
                                        </a>
                                        <a class="dropdown-item" href="{{ route('user.list-booking') }}">
                                            <i class="fa fa-list"></i>
                                            History Booking
                                        </a>
                                        @if(auth()->user()->is_affiliator == \App\Enums\AffiliatorStatus::YES)
                                        <a class="dropdown-item" href="{{ route('user.referral-bonus') }}">
                                            <i class="fa fa-usd"></i>
                                            Referral Bonus
                                        </a>
                                        <a class="dropdown-item" href="{{ route('affiliator.revenue') }}">
                                            <i class="fa fa-money"></i>
                                            Turnover
                                        </a>
                                        <a class="dropdown-item" href="{{ route('affiliator.bank.account') }}">
                                            <i class="fa fa-university"></i>
                                            Bank Account
                                        </a>
                                        <a class="dropdown-item" href="{{ route('user.request-payment') }}">
                                            <i class="fa fa-credit-card-alt"></i>
                                            Request Payment
                                        </a>
                                        @endif
                                    @else
                                        @php
                                            $roleName = strtolower(\App\Enums\UserRole::getKey(auth()->user()->role));

                                        @endphp
                                        <a class="dropdown-item" href="{{ route($roleName.'.dashboards.index') }}">
                                            <i class="fa fa-tachometer"></i>
                                            Dashboard
                                        </a>
                                    @endif
                                    </div>
                                </div>
							<div class="user_box_link"><a href="{{ route('user.logout') }}">Logout</a></div>
						</div>
                        @endauth
						@guest
						<div class="user_box ml-auto">
							<div class="user_box_login user_box_link"><a href="{{ route('user.login') }}">login</a></div>
							<div class="user_box_register user_box_link"><a href="{{ route('register') }}">register</a></div>
						</div>
						@endguest
					</div>
				</div>
			</div>
		</div>

		<!-- Main Navigation -->

		<nav class="main_nav">
			<div class="container">
				<div class="row">
					<div class="col main_nav_col d-flex flex-row align-items-center justify-content-start">
						<div class="logo_container">
							<div class="logo"><a href="{{ url('/') }}"><img src="" alt="">Service Hotel</a></div>
						</div>
						<div class="main_nav_container ml-auto">
							<ul class="main_nav_list">
								<li class="main_nav_item"><a href="/">home</a></li>
								{{-- <li class="main_nav_item"><a href="/about">about us</a></li> --}}
								<li class="main_nav_item"><a href="{{route('list-hotel')}}">all hotel</a></li>
								<li class="main_nav_item"><a href="/contact">contact</a></li>
							</ul>
						</div>

						<form id="search_form" class="search_form bez_1">
							<input type="search" class="search_content_input bez_1">
						</form>

						<div class="hamburger">
							<i class="fa fa-bars trans_200"></i>
						</div>
					</div>
				</div>
			</div>
		</nav>

	</header>

	<div class="menu trans_500">
		<div class="menu_content d-flex flex-column align-items-center justify-content-center text-center">
			<div class="menu_close_container"><div class="menu_close"></div></div>
			<div class="logo menu_logo"><a href="#"><img src="images/logo.png" alt=""></a></div>
			<ul>
				<li class="menu_item"><a href="#">home</a></li>
				<li class="menu_item"><a href="about.html">about us</a></li>
				<li class="menu_item"><a href="offers.html">offers</a></li>
				<li class="menu_item"><a href="blog.html">news</a></li>
				<li class="menu_item"><a href="contact.html">contact</a></li>
			</ul>
		</div>
	</div>

	<!-- Home -->
	@yield('slide')

    @yield('content')

    <!-- Footer -->

	<footer class="footer">
		<div class="container">
			<div class="row">

				<!-- Footer Column -->
				<div class="col-lg-3 footer_column">
					<div class="footer_col">
						<div class="footer_content footer_about">
							<div class="logo_container footer_logo">
								<div class="logo"><a href="#"><img src="images/logo.png" alt="">YourHotel247</a></div>
							</div>
							<p class="footer_about_text">The purpose of life, after all, is to live it, to taste experience to the utmost, to reach out eagerly and without fear for newer and richer experiences.</p>
							<ul class="footer_social_list">
								<li class="footer_social_item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
								<li class="footer_social_item"><a href="https://www.facebook.com/duc1ker/"><i class="fa fa-facebook-f"></i></a></li>
								<li class="footer_social_item"><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li class="footer_social_item"><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li class="footer_social_item"><a href="#"><i class="fa fa-behance"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

				<!-- Footer Column -->
				<div class="col-lg-3 footer_column">
					<div class="footer_col">
						<div class="footer_title">blog posts</div>
						<div class="footer_content footer_blog">
                            	<!-- Footer blog item -->
						@for ($i = 1; $i <= 3; $i++)
							<div class="footer_blog_item clearfix">
								<div class="footer_blog_image"><img src="{{asset('img/no_img.png')}}" alt="https://unsplash.com/@avidenov"></div>
								<div class="footer_blog_content">
									<div class="footer_blog_title"><a href="blog.html">This is my post</a></div>
									<div class="footer_blog_date">Nov 29, 2022</div>
								</div>
							</div>
                        @endfor

						</div>
					</div>
				</div>

				<!-- Footer Column -->
				<div class="col-lg-3 footer_column">
					<div class="footer_col">
						<div class="footer_title">tags</div>
						<div class="footer_content footer_tags">
							<ul class="tags_list clearfix">
								<li class="tag_item"><a href="#">hotel</a></li>
								<li class="tag_item"><a href="#">view</a></li>
								<li class="tag_item"><a href="#">beautiful</a></li>
								<li class="tag_item"><a href="#">video</a></li>
								<li class="tag_item"><a href="#">party</a></li>
								<li class="tag_item"><a href="#">travel</a></li>
							</ul>
						</div>
					</div>
				</div>

				<!-- Footer Column -->
				<div class="col-lg-3 footer_column">
					<div class="footer_col">
						<div class="footer_title">contact info</div>
						<div class="footer_content footer_contact">
							<ul class="contact_info_list">
								<li class="contact_info_item d-flex flex-row">
									<div><div class="contact_info_icon"><img src="{{asset('img/placeholder.svg')}}" alt=""></div></div>
									<div class="contact_info_text">Team Intern PHP - BAP</div>
								</li>
								<li class="contact_info_item d-flex flex-row">
									<div><div class="contact_info_icon"><img src="{{asset('img/phone-call.svg')}}" alt=""></div></div>
									<div class="contact_info_text">(+84) 123 456 789</div>
								</li>
								<li class="contact_info_item d-flex flex-row">
									<div><div class="contact_info_icon"><img src="{{asset('img/message.svg')}}" alt=""></div></div>
									<div class="contact_info_text"><a href="mailto:contactme@gmail.com?Subject=Hello" target="_top">internphp-baphue@gmail.com</a></div>
								</li>
								<li class="contact_info_item d-flex flex-row">
									<div><div class="contact_info_icon"><img src="{{asset('img/planet-earth.svg')}}" alt=""></div></div>
									<div class="contact_info_text"><a href="https://colorlib.com">www.internphpbaphue.com</a></div>
								</li>
							</ul>
						</div>
					</div>
				</div>

			</div>
		</div>
	</footer>

	<!-- Copyright -->

	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 order-lg-1 order-2  ">
					<div class="copyright_content d-flex flex-row align-items-center">
						<div><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This website is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://www.facebook.com/duc1ker/" target="_blank">Intern BAP HUE</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
					</div>
				</div>
				<div class="col-lg-9 order-lg-2 order-1">
					<div class="footer_nav_container d-flex flex-row align-items-center justify-content-lg-end">
						<div class="footer_nav">
							<ul class="footer_nav_list">
								<li class="footer_nav_item"><a href="#">home</a></li>
								<li class="footer_nav_item"><a href="about.html">about us</a></li>
								<li class="footer_nav_item"><a href="offers.html">offers</a></li>
								<li class="footer_nav_item"><a href="blog.html">news</a></li>
								<li class="footer_nav_item"><a href="contact.html">contact</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <a href="#top" class="to-top">
        <i class="fa fa-arrow-up"></i>
    </a>
</div>

<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
{{-- <script src="styles/bootstrap4/popper.js"></script> --}}
{{-- <script src="styles/bootstrap4/bootstrap.min.js"></script> --}}
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="{{asset('plugins/easing/easing.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#timkiem').keyup(function(){
            $('#result').html('');
            var seacrh = $('#timkiem').val();
            if (seacrh != '') {
                $('#result').css('display','inherit');
                var expression = new RegExp(seacrh,'i');
                $.getJSON('/json/hotel.json',function(data){
                    $.each(data,function(key,value){
                        if((value.name.search(expression)!= -1) || (value.address.search(expression)!= -1) || (value.category_name.search(expression)!= -1)){ // || value.description.search(expression) != -1
                            if (value.background != null) {
                                $('#result').append('<li style="cursor:pointer; display: flex; max-height: 200px;" class="list-group-item link-class"><img src="/img/hotel/'+value.background+'" width="100" class="" /><div style="flex-direction: column; margin-left: 2px;"><h4 width="100%"></h4><span style="display: -webkit-box; max-height: 8.2rem; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: normal; -webkit-line-clamp: 5; line-height: 1.6rem;" class="text-muted">'+value.name+'| Address: '+value.address+'</span></div></li>')
                            }else{
                                $('#result').append('<li style="cursor:pointer; display: flex; max-height: 200px;" class="list-group-item link-class"><img src="/img/hotel/home_slider.jpg" width="100" class="" /><div style="flex-direction: column; margin-left: 2px;"><h4 width="100%"></h4><span style="display: -webkit-box; max-height: 8.2rem; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: normal; -webkit-line-clamp: 5; line-height: 1.6rem;" class="text-muted">'+value.name+'| Address: '+value.address+'</span></div></li>')
                            }
                            // $('#result').append('<li style="cursor:pointer; display: flex; max-height: 200px;" class="list-group-item link-class"><img src="" width="100" class="" /><div style="flex-direction: column; margin-left: 2px;"><h4 width="100%">'+value.name+'</h4><span style="display: -webkit-box; max-height: 8.2rem; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: normal; -webkit-line-clamp: 5; line-height: 1.6rem;" class="text-muted">| '+value.address+'</span></div></li>')
                            // $.('#result').css('display','inherit');
                        }
                    });
                });
            }else{
                $('#result').css('display','none');
            }
        })
        $('#result').on('click','li',function(){
            var click_text = $(this).text().split('|');
            $("#timkiem").val($.trim(click_text[0]));
            $("#result").html('');
            $('#result').css('display','none');
        });
    })
</script>
<script src="{{asset('js/single_listing_custom.js')}}"></script>
<script>

    $(window).on('scroll', function(){
        if($(this).scrollTop() > 300) {
            $('.to-top').css('display', 'block');
        }else {
            $('.to-top').css('display', 'none');
        }
    })

    $("a[href='#top']").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });
    function remove_background(hotel_id,user_id) {
        {
            for (var count = 1; count <= 5; count++) {
                $('#'+hotel_id+'-'+user_id+'-'+count).css('color','#ccc');
            }
            // console.log('no');
        }
    }

    $(document).on('mouseenter','.rating',function(){
        var index = $(this).data("index");
        var hotel_id = $(this).data('hotel_id');
        var user_id = $(this).data('user_id');
        var rating = $(this).data("rating")
        remove_background(hotel_id,user_id);
        for(var count = 1; count <= index; count++)
        {
            $('#'+hotel_id+'-'+user_id+'-'+count).css('color','#ffcc00');
        }
    });

    $(document).on('mouseleave','.rating',function(){
        var index = $(this).data("index");
        var hotel_id = $(this).data('hotel_id');
        var user_id = $(this).data('user_id');
        var rating = $(this).data("rating")
        remove_background(hotel_id,user_id);
        for(var count = 1; count <= rating; count++)
        {
            $('#'+hotel_id+'-'+user_id+'-'+count).css('color','#ffcc00');
        }
    });

    $(document).on('click','.rating',function(){
        var index = $(this).data("index");
        var hotel_id = $(this).data('hotel_id');
        var user_id = $(this).data('user_id');
        var _token = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url:"{{route('insert-rating')}}",
            datatype: 'text',
            data:{index:index, hotel_id:hotel_id, user_id:user_id, _token: _token},
            success:function(data){
                remove_background(hotel_id,user_id)
                for(var count = 1; count <= index; count++)
                {
                    $('#'+hotel_id+'-'+user_id+'-'+count).css('color','#ffcc00');
                }
                // alert("you have rated "+index+" stars");
            },
        });
    });
</script>
<script src="{{asset('js/about_custom.js')}}"></script>
@yield('js')
</body>

</html>

