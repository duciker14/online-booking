@extends('layouts.admin.master')
@if (!isset($user))
    @section('title', 'Create Account Manager')
@else
    @section('title', 'Edit User')
@endif
@section('content')
    @extends('layouts.admin.master')
    @if (!isset($user))
        <h3 class="text-center mb-3">Create Account Manager</h3>
    @else
       <h3 class="text-center mb-3">EDIT MANAGER</h3>
    @endif

    <div class="row">
        <div class="col-md-6 offset-md-3">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (!isset($user))
                {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}
            @else
                {!! Form::open(['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
            @endif
            <div class="form-group">
                {!! Form::text('name', isset($user) ? $user->name : old('name'), [
                    'class' => 'form-control form-control-user',
                    'placeholder' => 'Full Name',
                    'required',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::text('email', isset($user) ? $user->email : old('email'), [
                    'class' => 'form-control form-control-user',
                    'placeholder' => 'Email',
                    'required',
                ]) !!}
            </div>
            @if (!isset($user))
                <div class="form-group">
                    {!! Form::text('password', old('password'), [
                        'class' => 'form-control form-control-user',
                        'placeholder' => 'Password',
                        'required',
                    ]) !!}

                </div>
                <div class="form-group">
                    {!! Form::text('hotel', old('hotel'), ['class' => 'form-control', 'placeholder' => 'Hotel Name', 'required']) !!}
                </div>
            @endif
            {{-- <div class="form-group">
                {!! Form::hii('role', ['1'=>'Manager', '2'=> 'User'], isset($user)?$user->role:'' , ['class'=>'form-control']) !!}
            </div> --}}
            <div class="row">
                @if (!isset($user))
                    {!! Form::submit('Add Manager', ['class' => 'col-md-6 offset-md-3 btn btn-primary btn-user btn-block']) !!}
                @else
                    {!! Form::submit('Update Manager', ['class' => 'col-md-6 offset-md-3 btn btn-primary btn-user btn-block']) !!}
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    {{-- </div> --}}
@endsection
