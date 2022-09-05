@extends('layouts.home.master')
@section('title', 'Detail Request')
@section('content')
<div class="page">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h3 class="text-center mb-3">Detail request!!</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Request date</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Payment date</th>
                            <th scope="col">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                           <tr>
                            <td>{{ auth()->user()->name }}</td>
                            <td>{{ auth()->user()->email }}</td>
                            <td>{{ $rq->request_date }}</td>
                            <td>${{ $rq->amount }}</td>
                            <td>${{ $rq->status }}</td>
                            <td>{{$rq->getPayemntRequestStatusName()}}</td>
                           </tr>
                        </tbody>
                      </table>
                      <div class="d-flex justify-content-end">
                        <a class="btn btn-primary" href="{{ url('request-payment/request-history') }}">Back</a>
                      </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection