@extends('layouts.home.master')
@section('title','Contact Page')

@section('content')
<div class="contact page">
    <div class="contact_background" style="background-image:url({{asset('img/contact.png')}})"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="contact_image">

                </div>
            </div>
            <div class="col-lg-7">
                <div class="contact_form_container">
                    <div class="contact_title">Contact</div>
                    <form action="{{route('send.contact')}}" id="contact_form" class="contact_form" method="post">
                        @csrf
                        <input type="text" name="name" class="contact_form_name input_field" placeholder="Name" required="required" data-error="Name is required.">
                        <input type="text" name="email" class="contact_form_email input_field" placeholder="E-mail" required="required" data-error="Email is required.">
                        <input type="text" name="subject" class="contact_form_subject input_field" placeholder="Subject" required="required" data-error="Subject is required.">
                        <textarea name="content" class="text_field contact_form_message" name="message" rows="4" placeholder="Message" required="required" data-error="Please, write us a message."></textarea>
                        <button type="submit" id="form_submit_button" class="form_submit_button button">send message<span></span><span></span><span></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@if (session()->has('success'))
    @section('js')
        <script>
            Toastify({
                text: "{{ session()->get('success') }}",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                duration: 3000
            }).showToast();
        </script>
    @endsection
@endif
