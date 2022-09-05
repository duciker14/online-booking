@extends('layouts.admin.master')
@section('title', 'Welcome Admin Dashboard')
@section('content')

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Manager</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalManager, 0, ',', '.') }}</div>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Affiliator</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalTourist[1]['total'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tourist</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalTourist[0]['total'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Hotels</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hotelAndRoomSummary['hotels'] }}</div>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Rooms</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hotelAndRoomSummary['rooms'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bookingAndRevenue['bookings'] }}</div>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Revenue ($)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($bookingAndRevenue['revenue'], 1, ',', '.') }}</div>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Profit ($)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($bookingAndRevenue['profit'], 1, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingRequests }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.revenues.chart')


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form action="{{ route('admin.dashboards.export-booking') }}" method="post" class="float-right">
                @csrf
                <input type="hidden" name="dateFrom" id="export-year">
                <input type="hidden" name="dateTo" id="export-month">
                <input type="submit" value="Export CSV" name="export_csvBooking" class="btn btn-success">
            </form>
            <h6 class="m-0 font-weight-bold text-primary">REVENUE BY BOOKING</h6>
        </div>
        <div class="card-body">
            <form action=" {{ route('admin.dashboards.index') }}" class="form-filter mb-3">
                <div class="form-group">
                    <label>From:</label>
                    <input type="date" class="form-control filterByDateFrom" name="dateFrom"
                        value="{{ $dateFrom ?? '' }}">
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
                            <th>NO</th>
                            <th>BOOKING USER</th>
                            <th>HOTEL</th>
                            <th>ROOM</th>
                            <th>CHECK IN</th>
                            <th>CHECK OUT</th>
                            <th>REVENUE($)</th>
                            <th>PROFIT($)</th>
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
                            <td>{{ number_format($values->total, 1, ',', '.') }}</td>
                            <td>{{ number_format(isset($values->id_aff) ? ($values->total / 100) * 20 : ($values->total / 100) * 30, 1, ',', '.') }}
                            </td>
                        </tr>
                        <?php
                        $stt++;
                    }
                    ?>
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-between">
                    <div class="dataTables_info">Showing {{ ($revenues->currentpage() - 1) * $revenues->perpage() + 1 }} to
                        {{ ($revenues->currentpage() - 1) * $revenues->perpage() + $revenues->count() }} of
                        {{ $revenues->total() }} entries</div>
                    {{ $revenues->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card shadow mb-4">
    <div class="card-header py-3">
        <form action="{{route('admin.dashboards.export-month')}}" method="post" class="float-right">
            @csrf
            <input type="submit" value="Export CSV" name="export_csvMonth" class="btn btn-success">
        </form>
        <h6 class="m-0 font-weight-bold text-primary">REVENUE IN THE LAST 6 MONTHS</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>MONTH</th>
                        @foreach ($revenueMonth as $month)
                        <th> {{ \Carbon\Carbon::parse($month->month)->format('m/Y')}} </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>REVENUE ($)</td>
                        @foreach ($revenueMonth as $month)
                        <td> {{ number_format($month->sumMonth, 2, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td>PROFIT ($)</td>
                        @foreach ($revenueMonth as $month)
                        <td> {{ number_format($month->profit, 2, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form action="{{route('admin.dashboards.export-year')}}" method="post" class="float-right">
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
                        <th>YEARS</th>
                        @foreach ($revenueYear as $year)
                        <th> {{$year->year}} </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>REVENUE ($)</td>
                        @foreach ($revenueYear as $year)
                        <td> {{ number_format($year->sumYear, 2, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td>PROFIT ($)</td>
                        @foreach ($revenueYear as $year)
                        <td> {{ number_format($year->profit, 2, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> --}}

@endsection
@section('js')
    <script type="text/javascript">
        $('#export-year').val($('.filterByDateFrom').val());
        $('#export-month').val($('.filterByDateTo').val());

        $(document).ready(function() {
            $('#dataTable').DataTable({
                searching: false,
                paging: false,
                info: false
            });
        });

        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["", ""],
                @for ($i = 0; $i < count($arr); $i++)
                    ["{{ $arr["$i"]['name'] }}", {{ $arr["$i"]['total'] }}],
                @endfor
            ]);

            var options = {
                title: 'Revenue from hotels'
            };

            var chart = new google.visualization.PieChart(document.getElementById('myChart'));
            chart.draw(data, options);
        }

        function drawChart2() {
            var data = google.visualization.arrayToDataTable([
                ["", ""],
                ["AFFILIATOR", {{ $sum_aff }}],
                ["NO-AFFILIATOR", {{ $sum }}],
            ]);

            var options = {
                title: 'Revenue from Affiliator'
            };

            var chart = new google.visualization.PieChart(document.getElementById('myChart2'));
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


            // $.ajax({
            //     type: 'GET',
            //     url: "{{ route('admin.dashboards.index') }}",
            //     datatype: 'text',
            //     data: {
            //         // token: "{{ csrf_token() }}",
            //         filterChart: filterChart
            //     },
            //     success: function(data) {
            //         _this.addClass('active');
            //         _this.siblings().removeClass('active');
            //     }
            // })
        });
    </script>
@endsection
