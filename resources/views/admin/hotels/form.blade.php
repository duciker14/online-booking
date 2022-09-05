@extends('layouts.admin.master')
@if (!isset($hotel))
    @section('title','Create Hotel')
@else
    @section('title','Edit Hotel')
@endif
@section('content')
@if (!isset($hotel))
{!! Form::open(['route' => 'admin.hotel.store', 'method'=>'POST']) !!}
@else
{!! Form::open(['route' => ['admin.hotel.update',$hotel->id], 'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
@endif
<div class="form-group">
    {!! Form::text('name', isset($hotel)?$hotel->name:'', ['class'=>'form-control', 'placeholder'=>'Hotel Name','required']) !!}
</div>
<div class="form-group">
    {!! Form::text('address', isset($hotel)?$hotel->address:'', ['class'=>'form-control form-control-user', 'placeholder'=>'Hotel Address','required']) !!}
</div>
<div class="form-group">
    {!! Form::textarea('description', isset($hotel)?$hotel->description:'', ['class'=>'form-control', 'placeholder'=>'Hotel Decription']) !!}
</div>
<div class="form-group">
    {!! Form::label('Background', 'Update Background', []) !!}
    {!! Form::file('bg', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 1', 'Update Image 1', []) !!}
    {!! Form::file('img1', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 2', 'Update Image 2', []) !!}
    {!! Form::file('img2', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 3', 'Update Image 3', []) !!}
    {!! Form::file('img3', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 4', 'Update Image 4', []) !!}
    {!! Form::file('img4', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 5', 'Update Image 5', []) !!}
    {!! Form::file('img5', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 6', 'Update Image 6', []) !!}
    {!! Form::file('img6', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 7', 'Update Image 7', []) !!}
    {!! Form::file('img7', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 8', 'Update Image 8', []) !!}
    {!! Form::file('img8', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 9', 'Update Image 9', []) !!}
    {!! Form::file('img9', ['class'=>'form-control ']) !!}
</div>
<div class="form-group">
    {!! Form::label('Image 10', 'Update Image 10', []) !!}
    {!! Form::file('img10', ['class'=>'form-control ']) !!}
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
