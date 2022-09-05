@extends('layouts.admin.master')
@section('title', 'Detail Account Manager')
@section('content')
    <div class="card show">
        <div class="card-header py-3">
            <h3 class="text-center mb-0">Detail Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if (isset($user->avatar))
                        <img src="{{ asset('img/users/' . $user->avatar) }}">
                    @else
                        <img src="{{ asset('img/users/avatar.png') }}">
                    @endif
                </div>

                <div class="col-md-8 info-user">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name</label>
                                <div class="form-control">{{ $user->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($user->role == \App\Enums\UserRole::MANAGER)
                                <div class="form-group">
                                    <label>Manager Hotel</label>
                                    <div class="form-control">{{ $user->hotel->name }}</div>
                                </div>
                            @else()
                                <div class="form-group">
                                    <label>Money ($)</label>
                                    <div class="form-control">{{ number_format($user->money, 2, ',', '.') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <div class="form-control">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <div class="form-control">{{ $user->phone }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address</label>
                                <div class="form-control">{{ $user->address }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="form-control">{{ $user->getUserGenderName() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date of birth</label>
                                <div class="form-control">{{ $user->birthdate }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <div class="form-control">{{ $user->getUserStatusName() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($user->is_affiliator == \App\Enums\AffiliatorStatus::YES && count($listPayment) > 0)
        <div class="card show">
            <div class="card-header py-3">
                <h3 class="text-center mb-0">List Payment Request</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered dataTable" id="listBooking" width="100%" cellspacing="0" role="grid"
                    aria-describedby="dataTable_info" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>#</th>
                            <th>Money Withdraw ($)</th>
                            <th>Request date</th>
                            <th>Payment date</th>
                            <th>Status</th>
                            <th style="width: 400px">Note</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($listPayment as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ number_format($item->amount, 2, ',', '.') }}</td>
                                <td>{{ $item->request_date }}</td>
                                <td>{{ $item->payment_date }}</td>
                                <td>{{ $item->getPayemntRequestStatusName() }}</td>
                                <td>{{ $item->reject_cause }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
