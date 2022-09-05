@extends('layouts.home.master')
@section('title', 'Profile')
@section('content')
    <div class="page-profile page">
        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-center mt-3 mb-3">My Profile</h3>
                    @if (Session::has('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('msg') }}
                        </div>
                    @endif
                    <form action="{{ route('tourist-update-profile', $user->id) }}" method="post" class="form-profile" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="avatar">
                                @isset($user->avatar)
                                    <img src="{{ asset('img/users/'.$user->avatar) }}" alt="">
                                @endisset
                                <div class="edit-avatar">
                                    <i class="fa fa-pencil"></i>
                                    <input type="file" name="avatar" id="avatar">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="username" placeholder="Full Name"
                                value="{{ $user->name }}">
                        </div>
                        @error('username')
                            <div class="form-group">
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            </div>
                        @enderror
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email"
                                value="{{ $user->email }}">
                        </div>
                        @error('email')
                            <div class="form-group">
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            </div>
                        @enderror
                        <div class="form-group">
                            <label>Phone number</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number"
                                value="{{ $user->phone }}">
                        </div>
                        @error('phone')
                            <div class="form-group">
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            </div>
                        @enderror
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address"
                                value="{{ $user->address }}">
                        </div>
                        @error('address')
                            <div class="form-group">
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            </div>
                        @enderror
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <div class="d-flex justify-content-between">
                                @foreach ($gender as $key => $value)
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="{{ ucfirst(strtolower($key)) }}"
                                            name="gender" value="{{ $value }}" @if($user->gender == $value) checked @endif>
                                        <label class="form-check-label"
                                            for="{{ ucfirst(strtolower($key)) }}">{{ ucfirst(strtolower($key)) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('gender')
                            <div class="form-group">
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            </div>
                        @enderror
                        <div class="form-group">
                            <label>Birthday</label>
                            <input type="date" class="form-control" name="birthday" placeholder="Birthday"
                                value="{{ $user->birthdate }}">
                        </div>
                        @error('birthday')
                            <div class="form-group">
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            </div>
                        @enderror
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h3 class="text-center mt-3 mb-3">Change Password</h3>
                    @if (Session::has('cpw'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('cpw') }}
                        </div>
                    @endif
                    <form action="{{ route('tourist-change-password') }}" method="post" class="change-password">
                        @csrf
                        <div class="form-group">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                name="current_password" placeholder="Current Password">
                        </div>
                        @error('current_password')
                            <div class="form-group">
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror
                        <div class="form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="New Password">
                        </div>
                        @error('password')
                            <div class="form-group">
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror
                        <div class="form-group">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" placeholder="Repeat Password">
                        </div>
                        @error('password_confirmation')
                            <div class="form-group">
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function readURL(input, name) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $(name).attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#avatar').on("change", function() {
        $(this).parents(".avatar").find('img').remove();
        $(this).parents(".avatar").append('<img src="">');
        readURL(this, $(this).parent(".edit-avatar").siblings("img"));
    });
</script>
@endsection
