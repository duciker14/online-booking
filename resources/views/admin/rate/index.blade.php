@extends('layouts.admin.master')
@section('title','List Reviews')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List reviews hotel</h6>
            </div>
            <div class="card-body">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <form action="{{route('list.reviews')}}" method="get" id="filterForm">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Hotel:
                                                    <select name="hotel" class="form-control custom-select">
                                                        <option value="all" selected>All</option>
                                                        @foreach($hotels as $value)
                                                            <option value="{{$value->id}}" {{($value->id == $selectedHotel) ? 'selected' : ''}}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Star:
                                                    <select name="star" class="form-control custom-select">
                                                        <option value="all" selected>All</option>
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <option value="{{$i}}" {{($i == $selectedStar) ? 'selected' : ''}}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="listBooking" width="100%" cellspacing="0"
                                role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Hotel</th>
                                        <th style="min-width: 100px">Star</th>
                                        <th style="width: 350px">Content</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($reviews as $key => $item)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->hotel->name }}</td>
                                            <td>
                                                <div class="rate-star" data-star="{{ $item->rate }}">
                                                    <i class="fa fa-star star-1"></i>
                                                    <i class="fa fa-star star-2"></i>
                                                    <i class="fa fa-star star-3"></i>
                                                    <i class="fa fa-star star-4"></i>
                                                    <i class="fa fa-star star-5"></i>
                                                </div>
                                            </td>
                                            <td>{{ $item->content }}</td>
                                            <td>
                                                <a href="#" class="btn btn-danger" title="Delete"
                                                    data-toggle="modal" data-target="#deleteModal{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure want
                                                            to delete this?</h5>
                                                        <button class="close" type="button" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">Select "Delete" below if you are ready to
                                                        delete this.</div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-dismiss="modal">Cancel</button>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('delete.reviews', $item->id) }}">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-between">
                        <div class="dataTables_info">Showing {{($reviews->currentpage()-1)*$reviews->perpage()+1}} to {{(($reviews->currentpage()-1)*$reviews->perpage())+$reviews->count()}} of {{$reviews->total()}} entries</div>
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('js')
    <script>
        jQuery(document).ready(function(e) {
            $('#listBooking').DataTable({
                searching: false, paging: false, info: false
            });
        });

        $('.rate-star').each(function() {
            let starNum = parseInt($(this).attr('data-star'));

            $(this).find('i').each(function(index, value) {
                if(index + 1 <= starNum) {
                    $(this).css('color', '#ffdc25');
                }else {
                    $(this).css('color', 'gray');
                }
            });
        });

    </script>
@endsection
@endsection
