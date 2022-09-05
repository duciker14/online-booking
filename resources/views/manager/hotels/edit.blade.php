@extends('layouts.admin.master')
@section('title','Edit My Hotel')
@section('content')
@if (!isset($hotel))
{!! Form::open(['route' => 'manager.hotel.store', 'method'=>'POST']) !!}
@else
{!! Form::open(['route' => ['manager.hotel.update',$hotel->id], 'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
@endif
{!! Form::label('', 'Hotel Name', []) !!}
<div class="form-group">
    {!! Form::text('name', isset($hotel)?$hotel->name:'', ['class'=>'form-control', 'placeholder'=>'Hotel Name','required']) !!}
</div>
{!! Form::label('', 'Address', []) !!}
<div class="form-group">
    {!! Form::text('address', isset($hotel)?$hotel->address:'', ['class'=>'form-control form-control-user', 'placeholder'=>'Hotel Address','required']) !!}
</div>
{!! Form::label('', 'Description', []) !!}
<div class="form-group">
    {!! Form::textarea('description', isset($hotel)?$hotel->description:'', ['class'=>'form-control', 'placeholder'=>'Hotel Decription']) !!}
</div>
<div class="form-group upload-img">
    {!! Form::label('Background', 'Upload Background', []) !!}
    <div class="btn-upload">
        <i class="fas fa-upload"></i>
        {!! Form::file('bg', ['class'=>'form-control file-img']) !!}
    </div>
    @isset($hotel->background)
        <img src="{{ asset('img/hotel/' . $hotel->background) }}" alt="">
    @endisset
</div>
@php
    if($hotel->images) {
        $images = json_decode($hotel->images);
    }
@endphp

<div class="form-group upload-gallery">
    {!! Form::label('Image 1', 'Upload Images', []) !!}
     <div class="btn-upload">
        <i class="fas fa-upload"></i>
        {!! Form::file('img[]', ['class'=>'form-control file-img', 'multiple']) !!}
    </div>
    <div class="add-gallery row">
        @if(isset($hotel))
            @php $images = json_decode($hotel->images); @endphp
            @if($images)
                @foreach($images as $key => $value)
                <div class="col-md-4 item-detail item mb-3">
                    <img src="{{ asset('img/hotel/' . $value) }}" alt="">
                </div>
                @endforeach
            @endif
        @endif
        </div>
</div>
<div class="row">
    @if (!isset($hotel))
        {!! Form::submit('Add Hotel', ['class'=>'col-md-6 offset-md-3 btn btn-primary btn-user btn-block']) !!}
    @else
        {!! Form::submit('Update Hotel', ['class'=>'col-md-6 offset-md-3 btn btn-primary btn-user btn-block']) !!}
    @endif
</div>
{!! Form::close() !!}
<hr>
@endsection
