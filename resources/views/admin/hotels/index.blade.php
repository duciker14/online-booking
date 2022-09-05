@extends('layouts.admin.master')
@section('title','List Hotels')
@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">LIST HOTELS</h6>
    </div>
    <div class="card-body">
        <form action="" class="form-inline mb-4 justify-content-end">
            <div class="form-group">
                <input class="form-control" name="key" placeholder="Search for...">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-sm"></i></button>
        </form>
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
                        <th>STT</th>
                        <th>Hotel Name</th>
                        <th>Hotline</th>
                        <th>Address</th>
                        <th>Manager</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1;
                    foreach ($hotels as $values) {
                    ?>
                        <tr>
                            <td>{{ $stt }}</td>
                            <td>{{ $values->name }}</td>
                            <td>{{ $values->hotline }}</td>
                            <td>{{ $values->address }}</td>
                            <td>{{ $values->user->name }}</td>
                            <td class="text-right" style="width:150px">
                                <form action="{{route('admin.hotel.delete', $values->id)}}" method="GET">
                                    <a class="btn btn-info" href="{{ route('admin.hotel.show',$values->id) }}"><i class="fas fa-info-circle"></i></a>
                                    {{-- <a class="btn btn-info" href="{{ route('admin.hotel.edit',$values->id) }}"><i class="fas fa-edit"></i></a> --}}
                                    @csrf
                                    <button onclick="return confirm('Want to delete?')" type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php
                        $stt++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 d-flex justify-content-between">
            <div class="dataTables_info">Showing {{($hotels->currentpage()-1)*$hotels->perpage()+1}} to {{(($hotels->currentpage()-1)*$hotels->perpage())+$hotels->count()}} of {{$hotels->total()}} entries</div>
            {{ $hotels->appends(request()->all())->links() }}
        </div>
    </div>
</div>
@endsection
