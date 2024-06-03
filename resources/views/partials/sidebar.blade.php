<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/logo-1.png') }}" alt="logo-sm-dark" height="24">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/logo-1.png') }}" alt="logo-dark" height="22">
            </span>
        </a>

        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/logo-1.png') }}" alt="logo-sm-light" height="12">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/logo-1.png') }}" alt="logo-light" height="50" style="margin-top:12px">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn"
        id="vertical-menu-btn">
        <i class="ri-menu-2-line align-middle"></i>
    </button>

    <div data-simplebar class="vertical-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">{{ __(Auth::user()->role) }}</li>

                <li>
                    <a href="/"
                        class="waves-effect {{ Route::is('dashboard') ? 'active' : '' }}">
                        <i class="mdi mdi-home"></i><span class="badge rounded-pill bg-success float-end"></span>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                @can('admin')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-table"></i>
                        <span>{{ __("Master Data") }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('master-data.location.index') }}">{{ __('Location') }}</a></li>
                        <li><a href="{{ route('master-data.department.index') }}">{{ __('Department') }}</a></li>
                        <li><a href="{{ route('master-data.employee.index') }}">{{ __('Employee') }}</a></li>
                        <li><a href="{{ route('master-data.shift.index') }}">{{ __('Shift') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-tools"></i>
                        <span>{{ __("Asset") }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('master-data.production-assets.index',['category'=> 'mesin']) }}">{{ __('Machine Asset') }}</a></li>
                        <li><a href="{{ route('master-data.production-assets.index', ['category'=> 'non-mesin']) }}">{{ __('Non-Machine Asset') }}</a></li>
                        <li><a href="{{ route('master-data.production-assets.index', ['category'=> 'sipil']) }}">{{ __('Civil Asset') }}</a></li>
                        <li><a href="{{ route('master-data.production-assets.index', ['category'=> 'utilities']) }}">{{ __('Utilities Asset') }}</a></li>
                        <li><a href="{{ route('master-data.it-assets.index') }}">{{ __('IT Asset') }}</a></li>
                    </ul>
                </li>
                @endcan
                 @cannot('staff')
                 <li>
                    <a href="{{ route("ticket.index") }}"
                        class="waves-effect {{ Route::is('ticket') ? 'active' : '' }}">
                        <i class="mdi mdi-ticket"></i><span class="badge rounded-pill bg-success float-end"></span>
                        <span>{{  Auth::user()->role == 'admin' ? __('Support Ticket') : __('Incoming Support Ticket')}}</span>
                    </a>
                </li>
                @endcannot
                @can('myTicket')
                <li>
                    <a href="{{ route("ticket.myTicket") }}"
                        class="waves-effect {{ Route::is('ticket') ? 'active' : '' }}">
                        <i class="mdi mdi-ticket"></i><span class="badge rounded-pill bg-success float-end"></span>
                        <span>{{ __('My Support Ticket') }}</span>
                    </a>
                </li>    
                @endcan
                 <li>
                    <a href="{{ route("report.index") }}"
                        class="waves-effect {{ Route::is('report') ? 'active' : '' }}">
                        <i class="mdi mdi-receipt"></i><span class="badge rounded-pill bg-success float-end"></span>
                        <span>{{ __('Report') }}</span>
                    </a>
                </li>
                 <li>
                    <a href="{{ route("history.index") }}"
                        class="waves-effect {{ Route::is('history') ? 'active' : '' }}">
                        <i class="mdi mdi-history"></i><span class="badge rounded-pill bg-success float-end"></span>
                        <span>{{ __('History') }}</span>
                    </a>
                </li>
                {{-- @endcannot --}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="dropdown px-3 sidebar-user sidebar-user-info">
        <button type="button" class="btn w-100 px-0 border-0" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="{{ Auth::user()->getPhoto() }}"
                        class="img-fluid header-profile-user rounded-circle" alt="">
                </div>

                <div class="flex-grow-1 ms-2 text-start">
                    
                    @if (Auth::user()->role == 'admin')
                    <span class="ms-1 fw-medium user-name-text">{{ Str::ucfirst(Auth::user()->username) }}</span>
                    @else
                    <span class="ms-1 fw-medium user-name-text">{{ Str::ucfirst(Auth::user()->pegawai->name) }}</span>
                    @endif
                </div>

                <div class="flex-shrink-0 text-end">
                    <i class="mdi mdi-dots-vertical font-size-16"></i>
                </div>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <a class="dropdown-item" href="{{ route("profile.index") }}"><i
                    class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span
                    class="align-middle">{{ __("Profile") }}</span></a>
            <button id="logout" class="dropdown-item" type="button">
                <i class="mdi mdi-lock text-muted font-size-16 align-middle me-1"></i>
                <span class="align-middle">{{ __("Logout") }}</span>
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

</div>


<!-- Left Sidebar End -->
