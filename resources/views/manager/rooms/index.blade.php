@extends('layouts.admin.master')
@section('title','List Rooms')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">LIST MANAGER</h6>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered" id="roomtable" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th style="width: 150px;">background</th>
                    <th>Price ($)</th>
                    <th>Status</th>
                    <th>Manage</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($list as $room)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $room->name }}</td>
                    <td>
                        <img width="100%" height="100px" src="{{asset('img/rooms/'.$room->background)}}" alt="">
                    </td>
                    <td>{{number_format($room->price, 2,',','.')}}</td>
                    <td>{{ $room->status == 0 ? 'Available' : 'Booking' }}</td>
                    <td>
                        <a href="{{route('manager.room.show',$room->id)}}" class="btn btn-info"><i class="fas fa-info-circle"></i></a>
                        <a href="{{route('manager.room.edit',$room->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                        {!! Form::open(['route'=>['manager.room.destroy',$room->id], 'method'=>'DELETE', 'class' => 'd-inline' ,'onsubmit'=>'return confirm("Want to delete?")']) !!}
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
