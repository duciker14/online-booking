@extends('layouts.admin.master')
@section('title','List Request Payment')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List payment requests</h6>
            </div>
            <div class="card-body">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <form action="{{route('list.payment.request')}}" method="get" id="filterForm">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Status:
                                                    <select name="status" class="form-control custom-select filterByStatus">
                                                        <option value="all" selected>All</option>
                                                        @foreach($paymentRequestStatus as $key => $value)
                                                            <option value="{{$value}}" {{((string)$value === $selectedStatus) ? 'selected' : ''}}>
                                                                {{ucfirst(strtolower($key))}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Request date:
                                                <input type="date" name="request_date" class="form-control" value="{{$requestDate}}">
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
                    <div class="ajax-notify"></div>
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
                                        <th>Money Current ($)</th>
                                        <th>Money Withdraw ($)</th>
                                        <th>Request date</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($paymentRequest as $key => $item)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td><a href="{{route('users.show', $item->user->id)}}">{{ $item->user->name }}</a></td>
                                            <td>{{ number_format($item->user->money, 2, ',', '.') }}</td>
                                            <td>{{ number_format($item->amount, 2, ',', '.') }}</td>
                                            <td>{{ $item->request_date }}</td>
                                            <td>{{ $item->getPayemntRequestStatusName() }}</td>
                                            <td>
                                                <a href="{{ route('detail.payment.request', $item->id) }}" class="btn btn-info"
                                                    title="Detail"><i class="fas fa-info-circle"></i></a>
                                                @if($item->status == $paymentRequestStatus['REQUEST'])
                                                <a href="{{ route('approval.payment.request', $item->id) }}" class="btn btn-success"
                                                    title="Approval"><i class="fas fa-check-circle"></i></a>
                                                <a href="#" class="btn btn-danger deleteModal{{ $item->id }}" title="Reject"
                                                    data-toggle="modal" data-target="#deleteModal{{ $item->id }}">
                                                    <i class="fas fa-times-circle"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Reject cause</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <textarea class="form-control" name="reject_cause" cols="30" rows="5"></textarea>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-primary reject" data-id="{{ $item->id }}">Reject</button>
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
                        <div class="dataTables_info">Showing {{($paymentRequest->currentpage()-1)*$paymentRequest->perpage()+1}} to {{(($paymentRequest->currentpage()-1)*$paymentRequest->perpage())+$paymentRequest->count()}} of {{$paymentRequest->total()}} entries</div>
                        {{ $paymentRequest->links() }}
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

            $('.reject').each(function() {
                $(this).on('click', function() {
                    let _this = $(this);
                    let rejectCause = $(this).parent('.modal-footer').siblings('.modal-body').find('textarea').val();
                    let paymentRequestId = $(this).attr('data-id');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('reject.payment.request') }}",
                        datatype: "text",
                        data: {
                            _token: '{{ csrf_token() }}',
                            rejectCause: rejectCause,
                            paymentRequestId: paymentRequestId
                        },
                        success: function(data) {
                            _this.parent('.modal-footer').siblings('.modal-header').find('.close').click();
                            $(`.deleteModal${paymentRequestId}`).remove();
                            $('.ajax-notify').html(
                                `<div class="alert alert-success" role="alert">
                                    Reject successfully
                                </div>`
                            );
                            window.location.reload();
                        },
                    });
                })
            })
        });
    </script>
@endsection
@endsection
