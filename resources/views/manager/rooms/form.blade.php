@extends('layouts.admin.master')
@if (isset($room))
@section('title','Edit - '.$room->name)
@else
@section('title','Create Room')
@endif
@section('content')

    <div class="card-header py-3">
        @if (isset($room))
            <h6 class="m-0 font-weight-bold text-primary">EDIT ROOM</h6>
        @else
            <h6 class="m-0 font-weight-bold text-primary">CREATE ROOM</h6>
        @endif
    </div>
    @if (!isset($room))
    {!! Form::open(['route' => 'manager.room.store', 'method'=>'POST' ,'enctype'=>'multipart/form-data']) !!}
    @else
    {!! Form::open(['route' => ['manager.room.update',$room->id], 'method'=>'PUT' ,'enctype'=>'multipart/form-data']) !!}
    @endif
        {!! Form::hidden('user', $user_id, []) !!}
        {!! Form::hidden('hotel', $hotel_id, []) !!}
    {!! Form::label('', 'Room Name', []) !!}
    <div class="form-group">
        {!! Form::text('name', isset($room)?$room->name:'', ['class'=>'form-control form-control-room', 'placeholder'=>'Room Name','required']) !!}
    </div>
    {!! Form::label('', 'Price', []) !!}
    <div class="form-group">
        {!! Form::text('price', isset($room)?$room->price:'', ['class'=>'form-control form-control-room', 'placeholder'=>'Price','required']) !!}
    </div>
    {!! Form::label('', 'Room type', []) !!}
    <div class="form-group">
        <select name="roomType" class="form-control custom-select">
            @foreach($roomType as $value)
                <option value="{{$value->id}}" @if(isset($room) && $room->room_type_id == $value->id) selected @endif>{{$value->name}}</option>
            @endforeach
        </select>
    </div>
    {!! Form::label('', 'Decription', []) !!}
    <div class="form-group">
        {!! Form::textarea('description', isset($room)?$room->description:'', ['class'=>'form-control form-control-room', 'placeholder'=>'...','required']) !!}
    </div>
    <div class="form-group upload-img">
        {!! Form::label('Background', 'Upload Background', []) !!}
        <div class="btn-upload">
            <i class="fas fa-upload"></i>
            {!! Form::file('bg', ['class'=>'form-control file-img']) !!}
        </div>
        @if(isset($room))
            <img src="{{ asset('img/rooms/' . $room->background) }}" alt="">
        @endif
    </div>
    
    <div class="form-group upload-gallery">
        {!! Form::label('Image 1', 'Upload Image', []) !!}
        <div class="btn-upload">
            <i class="fas fa-upload"></i>
            {!! Form::file('img[]', ['class'=>'form-control file-img', 'multiple']) !!}
        </div>
        <div class="add-gallery row">
        @if(isset($room))
            @php $images = json_decode($room->img); @endphp
            @if($images)
                @foreach($images as $key => $value)
                <div class="col-md-4 item-detail item mb-3">
                    <img src="{{ asset('img/rooms/' . $value) }}" alt="">
                </div>
                @endforeach
            @endif
        @endif
        </div>
    </div>
    <div class="row">
        @if (!isset($room))
            {!! Form::submit('Add room', ['class'=>'col-md-6 offset-md-3 btn btn-primary btn-room btn-block']) !!}
        @else
            {!! Form::submit('Update room', ['class'=>'col-md-6 offset-md-3 btn btn-primary btn-room btn-block']) !!}
        @endif
    </div>
    {!! Form::close() !!}

@endsection()
