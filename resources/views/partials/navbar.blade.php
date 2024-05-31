<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('images/logo-1.png') }}" alt="logo-sm-dark" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('images/logo-1.png') }}" alt="logo-dark" height="25">
                    </span>
                </a>
                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('images/logo-1.png') }}" alt="logo-sm-light" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('images/logo-1.png') }}" alt="logo-light" height="20">
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn"
                id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>
            <!-- start page title -->
            @if (Session::get('shift') != null)
                <div class="page-title-box align-self-center d-none d-md-block">
                    <span class="btn btn-rounded btn-success btn-sm" data-bs-toggle="button" style="margin-left: 20px">
                        {{ Session::get('shift') }}</span>
                </div>
            @endif
            <!-- end page title -->
        </div>
        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block ms-1">

                <span id="clock" class="btn btn-rounded btn-danger btn-sm d-none"></span>
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            @cannot('admin')
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-notification-3-line"></i>
                        @if (auth()->user()->unreadNotifications->count())
                            <span class="noti-dot"></span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0"> {{ __('Notifications') }} </h6>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px; ">
                            @if (auth()->user()->unreadNotifications->count())
                                @foreach (auth()->user()->unreadNotifications as $item)
                                    <a href="{{ route('notif', ['id' => Crypt::encrypt($item->id)]) }}"
                                        class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                    <i class="ri-error-warning-line"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mb-1">{{ $item->data['messages'] }}</h6>
                                                <div class="font-size-12 text-muted">

                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                        {{ $item->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <span href="" class="text-reset notification-item">

                                    <div class="text-center">
                                        <h6 class="mb-1">{{ 'Nothing Notifications' }}</h6>
                                    </div>
                                </span>
                            @endif
                        </div>
                        <div class="p-2 border-top">
                            <div class="d-grid">
                                <a class="btn btn-sm btn-link text-danger font-size-14 text-center"
                                    href="{{ route('read') }}">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> {{ __('Mark As Read') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcannot
        </div>
    </div>
</header>
