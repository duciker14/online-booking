<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="card shadow mb-4">
    <div class="card-header">
        <form action="{{ route('admin.dashboards.index') }}" method="GET" id="form-filter">
            <input type="hidden" name="filterChart">
        </form>
        <div class="btn btn-primary active filter-chart" data-filter="all">All Time</div>
        <div class="btn btn-primary filter-chart" data-filter="12">12 Months</div>
        <div class="btn btn-primary filter-chart" data-filter="6">6 Months</div>
    </div>
    <div class="card-body row">
        <div class="col-md-6">
            <div id="myChart" style="width:100%; height:300px;"></div>
        </div>
        <div class="col-md-6">
            <div id="myChart2" style="width:100%; height:300px;"></div>
        </div>
    </div>
</div>
