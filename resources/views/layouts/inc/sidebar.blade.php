@if (auth()->user()->role == \App\Enums\UserRole::ADMIN)
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center"
            href="{{ url('/') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">ADMIN<sup></sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">


            <a class="nav-link" href="{{ route('admin.dashboards.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            LIST MANAGE
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-user"></i>
                <span>Account</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{route('create-user')}}">Create Manager</a>
                    <a class="collapse-item" href="{{route('users.index')}}">List Manager</a>
                    <a class="collapse-item" href="{{route('listTourist')}}">List Tourist</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#hotel"
                aria-expanded="true" aria-controls="hotel">
                <i class="fas fa-fw fa-building"></i>
                <span>Hotels</span>
            </a>
            <div id="hotel" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{route('admin.hotel.index')}}">List Hotel</a>
                    <a class="collapse-item" href="{{route('admin.room.type')}}">List Room Type</a>
                    <a class="collapse-item" href="{{ route('admin.rooms.index') }}">List Rooms</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('list.booking') }}">
                <i class="fas fa-fw fa-atlas"></i>
                <span>Bookings</span>
            </a>
        </li>
        <!-- Nav Item - Utilities Collapse Menu -->
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.rooms.index') }}">
                <i class="fas fa-fw fa-bed"></i>
                <span>Rooms</span>
            </a>
        </li> --}}
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('list.payment.request') }}">
                <i class="fas fa-fw fa-credit-card"></i>
                <span>Request Payment</span>
            </a>
        </li>
        <!-- Nav Item - Utilities Collapse Menu -->
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Categories</span>
            </a>
        </li> --}}
        <!-- Nav Item - Utilities Collapse Menu -->
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('list.reviews') }}">
                <i class="fas fa-fw fa-star"></i>
                <span>Rates</span>
            </a>
        </li> --}}

        <!-- Divider -->
        <hr class="sidebar-divider">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
@else
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">MANAGER<sup></sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('manager.dashboards.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            LIST MANAGE
        </div>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-building"></i>
                <span>My Hotels</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('manager.hotel.show', auth()->user()->hotel->id) }}">Details</a>
                    <a class="collapse-item" href="{{ route('manager.hotel.index') }}">Update My Hotels</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#rooms"
                aria-expanded="true" aria-controls="rooms">
                <i class="fas fa-fw fa-bed"></i>
                <span>Rooms</span>
            </a>
            <div id="rooms" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('manager.room.create') }}">Create | Edit</a>
                    <a class="collapse-item" href="{{ route('manager.room.index') }}">List Rooms</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bookings"
                aria-expanded="true" aria-controls="bookings">
                <i class="fas fa-fw fa-atlas"></i>
                <span>Bookings</span>
            </a>
            <div id="bookings" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('manager.bookings.create') }}">Create</a>
                    <a class="collapse-item" href="{{ route('manager.bookings.index') }}">List Bookings</a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Utilities Collapse Menu -->
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('manager.list.reviews') }}">
                <i class="fas fa-fw fa-star"></i>
                <span>Rates</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
@endif
