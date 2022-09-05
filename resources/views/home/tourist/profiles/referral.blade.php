@extends('layouts.home.master')
@section('title', 'Referral Bonus')
@section('content')
    <div class="page">
        <div class="container">
            <div class="referral-info">
                <h2 class="text-left mt-3 mb-3">Referral Bonus</h2>
                <h3 class="text-left mt-2 mb-4">Your referral link (Share it with your friends!)</h3>
                <a href="{{ $user->referen_url }}">{{ $user->referen_url }}</a>
                <div class="mt-4 mb-4">
                    <h3>Your referees</h3>
                    <h5>Total <span>{{ $userReferred->total() }}</span> people referred</h5>
                    <h5>Total money referral bonus: <span>{{ number_format($user->money, 2, ',', '.') }} $</span></h5>
                </div>
            </div>
            @if($userReferred->count() > 0)
            <table class="table table-bordered dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userReferred as $key => $value)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->getUserStatusName() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="dataTables_info">Showing {{($userReferred->currentpage()-1)*$userReferred->perpage()+1}} to {{(($userReferred->currentpage()-1)*$userReferred->perpage())+$userReferred->count()}} of {{$userReferred->total()}} entries</div>
                {{ $userReferred->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection

