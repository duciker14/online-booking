@extends('layouts.admin.master')
@section('title','List Room Type')
@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Create Room Type</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.room.type') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="roomType" placeholder="Enter Room Type">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Create</button>
                        </div>
                    </div>
                    @error('roomType')
                        <div class="form-group">
                            <span class="text-danger" role="alert">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Room Type</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            <table class="table table-bordered" id="tablehotel" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Room Type Name</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomType as $key => $value)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $value->name }}</td>
                            <td><a href="{{ route('admin.room.type.status', $value->id) }}">{{ $value->getRoomTypeStatusName() }}</a></td>
                            <td class="text-right">
                                {{-- <a class="btn btn-warning" href="{{ route('admin.room.type.update', $value->id) }}"><i class="fa fa-edit"></i></a> --}}
                                <a class="btn btn-danger" href="{{ route('admin.room.type.delete', $value->id) }}"
                                    onclick="return confirm('Are you sure you want to delete this?')"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
