@extends('layouts.admin.master')
@section('title','List Categories')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LIST CATEGORIES</h6>
        </div>
        <form method="GET" class="pt-3 d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" name="key" class="form-control bg-light border-0 small" placeholder="Search for..."
                    aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>*</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Acction</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <select id="" class="form-control set_status" data-id="{{ $category->id }}">
                                    <option value="0" {{$category->status == 0 ? "selected" : ""}}>Hidden</option>
                                    <option value="1" {{$category->status == 1 ? "selected" : ""}}>Show</option>
                                </select>
                            </td>
                            <td>
                                <a class="btn btn-info" href="{{ route('admin.categories.edit', $category->id) }}"><i class="fas fa-info-circle"></i></a>
                                <a onclick = "return confirm('Want to delete?')" class="btn btn-danger" href="{{ route('admin.categories.destroy', $category->id) }}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $categories->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
@endsection
@if(session()->has('success'))
    @section('js')
        <script>
            Toastify({
            text: "{{ session()->get('success') }}",
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            duration: 3000
            }).showToast();
        </script>
    @endsection
@endif

@if(session()->has('error'))
    @section('js')
        <script>
            Toastify({
            text: "{{ session()->get('error') }}",
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            duration: 3000
            }).showToast();
        </script>
    @endsection
@endif

@section('js')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                searching: false, paging: false, info: false
            });

            $('.set_status').change(function(){
                var category_id = $(this).data('id');
                var status = $(this).val();
                $.ajax({
                    url: "{{ route('admin.categories.status') }}",
                    type: 'POST',
                    data: {
                        category_id: category_id,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res){
                        console.log(res);
                        if(res.status == 200){
                            Toastify({
                                text: res.success,
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                duration: 3000
                            }).showToast();
                        }
                    },
                    error: function(err){
                        console.log(err);
                    }
                });
            });
        });
    </script>
@endsection
