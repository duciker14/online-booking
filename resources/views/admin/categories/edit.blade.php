@extends('layouts.admin.master')
@section('title','Detail Categories')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail</h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><strong>Name:</strong> {{ $category->name }}</h5>
                    <h5 class="card-title"><strong>Status: </strong>{{ $category->status == 0 ? "Hidden" : "Show" }}</h5>

                    <div class="row ml-1 mt-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
