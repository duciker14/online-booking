@extends('layouts.home.master')
@section('title', 'Turnover')
@section('content')

<div class="page">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">REVENUE BY BOOKING</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <form action="" class="form-inline mb-3">
                    {{-- <select name="year" class="form-control custom-select filterByYear" style="width:10%; margin-right:5px;">
                        <option value="all" selected> Year </option>
                        @php
                        $startYear = \Carbon\Carbon::now()->year;
                        $endYear = \Carbon\Carbon::now()->subYears(4)->year;
                        @endphp
                        @for($startYear; $startYear >= $endYear; $startYear--)
                        <option value="{{$startYear}}" @if((string)$startYear===$yearRequest) selected @endif> {{$startYear}} </option>
                        @endfor
                    </select>
                    <select name="month" class="form-control custom-select filterByMonth" style="width:10%; margin-right:5px;">
                        <option value="all" selected> Month </option>
                        @for($i = 1; $i <= 12; $i++) <option value="{{$i}}" @if((string)$i===$monthRequest) selected @endif> {{$i}} </option>
                            @endfor
                    </select>
                    <select name="date" class="form-control custom-select filterByDate" style="width:10%; margin-right:5px;">
                        <option value="all" selected> Date </option>
                        @for($i = 1; $i <= 31; $i++) <option value="{{$i}}" @if((string)$i===$dateRequest) selected @endif> {{$i}} </option>
                            @endfor
                    </select> --}}

                    <div class="input-group">
                        <label class="text-dark" for="">From date:</label>&ensp;
                        <input type="date" name="dateFrom" value="{{ isset(request()->dateFrom) ? request()->dateFrom : '' }}" class="form-control">
                    </div> &emsp; - &emsp;
                    <div class="input-group">
                        <label class="text-dark" for="">To date:</label>&ensp;
                        <input type="date" name="dateTo" value="{{ isset(request()->dateTo) ? request()->dateTo : '' }}" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-right:5px;"> <i class="fa fa-filter"></i></button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>BOOKING USER</th>
                            <th>HOTEL</th>
                            <th>ROOM</th>
                            <th>CHECK IN</th>
                            <th>CHECK OUT</th>
                            <th>PRICE ($)</th>
                            <th>PROFIT ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stt = 1;
                        foreach ($revenues as $values) {
                        ?>
                            <tr>
                                <td>{{ $stt }}</td>
                                <td>{{ $values->userName }}</td>
                                <td>{{ $values->hotelName }}</td>
                                <td>{{ $values->roomName }}</td>
                                <td>{{ $values->check_in }}</td>
                                <td>{{ $values->check_out }}</td>
                                <td>{{ number_format($values->total, 2, ',', '.') }}</td>
                                <td>{{ number_format($values->total*0.1, 2, ',', '.') }}</td>
                            </tr>
                        <?php
                            $stt++;
                        }
                        ?>
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-between">
                    <div class="dataTables_info">Showing {{($revenues->currentpage()-1)*$revenues->perpage()+1}} to {{(($revenues->currentpage()-1)*$revenues->perpage())+$revenues->count()}} of {{$revenues->total()}} entries</div>
                    {{ $revenues->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">REVENUE IN THE LAST 6 MONTHS</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>MONTH</th>
                            @foreach($revenueMonth as $month)
                            <th> {{ \Carbon\Carbon::parse($month->month)->format('m/Y')}} </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>REVENUE ($)</td>
                            @foreach($revenueMonth as $month)
                            <td> {{ number_format($month->sumMonth, 2, ',', '.') }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>TURNOVER ($)</td>
                            @foreach($revenueMonth as $month)
                            <td> {{ number_format($month->sumMonth*0.1, 2, ',', '.') }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">REVENUE IN THE LAST 5 YEARS</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>YEARS</th>
                            @foreach($revenueYear as $year)
                            <th> {{$year->year}} </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>REVENUE ($)</td>
                            @foreach($revenueYear as $year)
                            <td> {{ number_format($year->sumYear, 2, ',', '.') }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>TURNOVER ($)</td>
                            @foreach($revenueYear as $year)
                            <td> {{ number_format($year->sumYear*0.1, 2, ',', '.') }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: false,
            paging: false,
            info: false
        });
    });
</script>
@endsection