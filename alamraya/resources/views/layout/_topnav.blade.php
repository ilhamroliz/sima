<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left form-group">
        <a href="{{ url('home') }}" class="logo">
            <span>
                <img src="{{ asset('assets/images/logo.png') }}" alt="" height="30">
            </span>
            <i>
                <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="28">
            </i>
        </a>
    
        <div style="margin-top: -20px;">
            <span class="col-12" style="color: #8E9BA3;">
                {{ \GeniusTS\HijriDate\Hijri::convertToHijri(Carbon\Carbon::now('Asia/Jakarta'))->format('l d F o') }}
            </span>
        </div>
    </div>

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">
            <li class="list-inline-item dropdown notification-list">
                <span style="color: #fff"><strong>{{ Auth::guard('team')->user()->ct_name }}</strong></span>
            </li>

            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="text-overflow"><small>Welcome ! {{ Auth::guard('team')->user()->ct_name }}</small> </h5>
                    </div>

                    <!-- item-->
                    <a href="{{ url('profile') }}" class="dropdown-item notify-item">
                        <i class="zmdi zmdi-account-circle"></i> <span>Profile</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="zmdi zmdi-settings"></i> <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="zmdi zmdi-lock-open"></i> <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('logout') }}" class="dropdown-item notify-item">
                        <i class="zmdi zmdi-power"></i> <span>Logout</span>
                    </a>

                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                    <i class="dripicons-menu"></i>
                </button>
            </li>
            {{-- <li class="hide-phone app-search">
                <div role="search" class="form-group">
                    <span style="color: #fff"><strong></strong>
                    </span>
                </div>
            </li> --}}
        </ul>

    </nav>

</div>