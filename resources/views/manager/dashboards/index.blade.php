@extends('layouts.admin.master')
@section('content')

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Bookings</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bookingAndRevenue['bookings'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-fw fa-bed fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Revenue ($)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($bookingAndRevenue['revenue'], 1, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Profit ($)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($bookingAndRevenue['revenue']*0.7, 1, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header">
        <form action="{{ route('manager.dashboards.index') }}" method="GET" id="form-filter">
            <input type="hidden" name="filterChart">
        </form>
        <div class="btn btn-primary active filter-chart" data-filter="all">All Time</div>
        <div class="btn btn-primary filter-chart" data-filter="12">12 Months</div>
        <div class="btn btn-primary filter-chart" data-filter="6">6 Months</div>
    </div>
    <div class="card-body row">
    <div class="col-md-4">
        <div class="card w-100" style="width: 18rem;">
            <div class="card-body">
                <!-- <h5 class="card-title">Revenues by Age</h5> -->
                <div id="chartAge"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-1">
        <div class="card w-100" style="width: 18rem;">
            <div class="card-body">
                <!-- <h5 class="card-title">Revenues by Gender</h5> -->
                <div id="chartGender"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-1">
        <div class="card w-100" style="width: 18rem;">
            <div class="card-body">
                <!-- <h5 class="card-title">Revenues by Affiliator</h5> -->
                <div id="chartAffiliator"></div>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <!-- <div class="card shadow mb-4">
            <div class="card-header py-3">
                <form action="{{route('manager.dashboards.export-year')}}" method="post" class="float-right">
                    @csrf
                    <input type="submit" value="Export CSV" name="export_csvYear" class="btn btn-success">
                </form>
                <h6 class="m-0 font-weight-bold text-primary">REVENUE IN THE LAST 5 YEARS</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Year</th>
                                @foreach($revenueYear as $year)
                                <th> {{$year->year}} </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Revenue ($)</th>
                                @foreach($revenueYear as $year)
                                <td> {{ number_format($year->sumYear, 2, ',', '.') }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Profit ($)</th>
                                @foreach($revenueYear as $year)
                                <td> {{ number_format(($year->sumYear)*0.7, 2, ',', '.') }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <form action="{{route('manager.dashboards.export-month')}}" method="post" class="float-right">
                    @csrf
                    <input type="submit" value="Export CSV" name="export_csvYear" class="btn btn-success">
                </form>
                <h6 class="m-0 font-weight-bold text-primary">REVENUE IN THE LAST 6 MONTHS</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Month</th>
                                @foreach($revenueByMonth as $month)
                                <th> {{ \Carbon\Carbon::parse($month->month)->format('m/Y')}} </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Revenue ($)</th>
                                @foreach($revenueByMonth as $month)
                                <td> {{ number_format($month->sumMonth, 2, ',', '.') }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Profit ($)</th>
                                @foreach($revenueByMonth as $month)
                                <td> {{ number_format(($month->sumMonth)*0.7, 2, ',', '.') }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <form action="{{ route('manager.dashboards.export-booking') }}" method="post" class="float-right">
                    @csrf
                    <input type="hidden" name="dateFrom" id="export-year">
                    <input type="hidden" name="dateTo" id="export-month">
                    <input type="submit" value="Export CSV" name="export_csvBooking" class="btn btn-success">
                </form>
                <h6 class="m-0 font-weight-bold text-primary">REVENUE BY BOOKING</h6>
            </div>
            <div class="card-body">
                <form action=" {{ route('manager.dashboards.index') }}" class="form-filter mb-3">
                    <div class="form-group">
                        <label>From:</label>
                        <input type="date" class="form-control filterByDateFrom" name="dateFrom" value="{{ $dateFrom ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>To:</label>
                        <input type="date" class="form-control filterByDateTo" name="dateTo" value="{{ $dateTo ?? '' }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"> <i class="fa fa-filter"></i></button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Booking</th>
                                <th>Room</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Revenue ($)</th>
                                <th>Profit ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenues as $key => $value)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $value->userName }}</td>
                                <td>{{ $value->roomName }}</td>
                                <td>{{ $value->check_in }}</td>
                                <td>{{ $value->check_out }}</td>
                                <td>{{ number_format($value->total, 2, ',', '.') }}</td>
                                <td>{{ number_format(($value->total)*0.7, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="ml-3 dataTables_info">
                        Showing {{ ($revenues->currentpage() - 1) * $revenues->perpage() + 1 }} to
                        {{ ($revenues->currentpage() - 1) * $revenues->perpage() + $revenues->count() }} of
                        {{ $revenues->total() }} entries
                    </div>
                    {{ $revenues->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
            $('#dataTable').DataTable({
                searching: false,
                paging: false,
                info: false
            });
        });


    $('#export-year').val($('.filterByDateFrom').val());
    $('#export-month').val($('.filterByDateTo').val());

    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(revenuesByAge);
    google.charts.setOnLoadCallback(revenuesByGender);
    google.charts.setOnLoadCallback(revenuesByAffiliator);

    function revenuesByAge() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Revenues by Age'],
            @foreach ($ageTotal as $item)
                ["{{$item->age}}", {{$item->total}}],
            @endforeach
        ]);

        var options = {
            title: 'Revenues by Age'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartAge'));

        chart.draw(data, options);
    }

    function revenuesByGender() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Revenues by Age'],
            @foreach ($bookings as $item)
                [@if($item->gender == 1) "Male" @else "Female" @endif, {{$item->total}}],
            @endforeach
        ]);

        var options = {
            title: 'Revenues by Gender'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartGender'));

        chart.draw(data, options);
    }

    function revenuesByAffiliator() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Revenues by Affiliator'],
            ['Affiliator', {{$totalAffiliators}}],
            @if ($totalNotAffiliator == null)
            ['Not Affiliator', {{0}}],
            @else
            ['Not Affiliator', {{$totalNotAffiliator->totalNotAffiliator}}],
            @endif
        ]);

        var options = {
            title: 'Revenues by Affiliator'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartAffiliator'));

        chart.draw(data, options);
    }
    const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        let value = params.filterChart;
        $('.filter-chart').each(function() {

            if($(this).data('filter') == value) {
                $(this).addClass('active');
                $(this).siblings().removeClass('active');
            }
        })

        $('.filter-chart').on('click', function() {
            let _this = $(this),
                filterChart = $(this).attr('data-filter');

            $('#form-filter').find('input').val(filterChart);
            $('#form-filter').submit();
            _this.addClass('active');
            _this.siblings().removeClass('active');
        });
</script>
@endsection