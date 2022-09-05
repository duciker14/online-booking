@extends('layouts.admin.master')
@section('title', 'List Account Manager')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Account Tourist</h6>
        </div>
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        {{-- @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif --}}
        <div class="card-body">
            {{-- <form action="{{route('users.index')}}" method="get" id="filterForm" class="mb-3">
                <div class="row">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Role:
                                    <select name="role" class="form-control custom-select filterByHotel">
                                        <option value="all" selected>All</option>
                                        @if($role)
                                        @foreach ($role as $key => $value)
                                            <option value="{{ $value }}"
                                                {{ (string) $value === $selectedRole ? 'selected' : '' }}>
                                                {{ ucfirst(strtolower($key)) }}
                                            </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>Status:
                                    <select name="status" class="form-control custom-select filterByStatus">
                                        <option value="all" selected>All</option>
                                        @foreach ($status as $key => $value)
                                            <option value="{{ $value }}"
                                                {{ (string) $value === $selectedStatus ? 'selected' : '' }}>
                                                {{ ucfirst(strtolower($key)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form> --}}
            <div class="table-responsive">
                <table class="table table-bordered " id="usertable" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" style="width: 150px">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Affiliator</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listTourist as $key => $user)
                            <tr>
                                <td scope="row">{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                <td><a href="tel:{{$user->phone}}">{{$user->phone}}</a></td>
                                <td>{{$user->getUserIsAffiliation()}}</td>
                                <td>{{$user->getUserGenderName()}}</td>
                                <td>
                                    <a href="{{ route('users-change_active', $user->id) }}">
                                        {{ $user->getUserStatusName() }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"><i
                                            class="fas fa-info-circle"></i></a>
                                    {{-- <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i
                                            class="fas fa-edit"></i></a> --}}
                                    {!! Form::open([
                                        'route' => ['users.destroy', $user->id],
                                        'method' => 'DELETE',
                                        'class' => 'd-inline',
                                        'onsubmit' => 'return confirm("Want to delete?")',
                                    ]) !!}
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            {{-- <div class="mt-4 d-flex justify-content-between">
                <div class="dataTables_info">Showing {{ ($list->currentpage() - 1) * $list->perpage() + 1 }} to
                    {{ ($list->currentpage() - 1) * $list->perpage() + $list->count() }} of {{ $list->total() }} entries</div>
                {{ $list->links() }}
            </div> --}}
        </div>
    </div>
@endsection
