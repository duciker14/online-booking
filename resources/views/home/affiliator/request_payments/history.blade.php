@extends('layouts.home.master')
@section('title', 'Request History')
@section('content')
<div class="page">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h3 class="text-center mb-3">Your request history!!</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Request date</th>
                            <th scope="col">Payment date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Manage</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($requestPayment as $item)
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->request_date }}</td>
                                    <td>{{ $item->payment_date }}</td>
                                    <td>{{ $item->getPayemntRequestStatusName() }}</td>
                                    <td style="display: flex;">
                                        <a href="{{route('user.show-request',$item->id)}}" style="margin: 0 10px;" class="btn btn-info"><i class="fa fa-info-circle"></i></a>
                                        {{-- <a href="{{route('user.edit-request',$item->id)}}" style="margin: 0 10px;" class="btn btn-warning"><i class="fa fa-edit"></i></a> --}}
                                        {{-- {!! Form::open(['route'=>['user.delete-request',$item->id], 'method'=>'DELETE', 'onsubmit'=>'return confirm("Want to delete?")']) !!}
                                            <button style="margin: 0 10px;" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        {!! Form::close() !!} --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div class="d-flex justify-content-end">
                        <a class="btn btn-primary"href="{{ url('request-payment') }}">Back</a>
                      </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
