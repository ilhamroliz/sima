<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">Navigation</li>
                <li class="{{ Request::is('home') ? 'active' : ''}}">
                    <a href="{{url('/home')}}">
                        <i class="fi-air-play"></i><span> Dashboard </span>
                    </a>
                </li>
                <li class="{{ Request::is('manajemen-project/*') ? 'active' : '' }}">
                    <a href="javascript: void(0);" class="{{ Request::is('manajemen-project/*') ? 'active' : '' }}"><i class="fi-target"></i> <span> Manajemen Project </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="{{ Request::is('manajemen-project/daftar-project') ? 'active' : '' || Request::is('manajemen-project/tambah-project') ? 'active' : '' }}">
                            <a class="" href="{{ url('manajemen-project/daftar-project') }}">Daftar Project</a>
                        </li>
                        <li class="{{ Request::is('manajemen-project/project-progress') ? 'active' : '' || Request::is('manajemen-project/project-progress/*') ? 'active' : '' }}">
                            <a href="{{ url('manajemen-project/project-progress') }}">
                                Project Progress
                            </a>
                        </li>
                        <li class="{{ Request::is('manajemen-project/time-schedule') ? 'active' : '' || Request::is('manajemen-project/time-schedule/*') ? 'active' : ''}}">
                            <a href="{{ url('manajemen-project/time-schedule') }}">Time Schedule</a>
                        </li>
                        <li class="{{ Request::is('manajemen-project/project-team') ? 'active' : '' || Request::is('manajemen-project/project-team/*') ? 'active' : ''}}">
                            <a href="{{ url('manajemen-project/project-team') }}">Project Team</a>
                        </li>
                        <li class="{{ Request::is('manajemen-project/agenda-project') ? 'active' : '' || Request::is('manajemen-project/agenda-project/*') ? 'active' : ''}}">
                            <a href="{{ url('manajemen-project/agenda-project') }}">Agenda Project</a>
                        </li>
                        <li class="{{ Request::is('manajemen-project/berita-acara-project') ? 'active' : '' || Request::is('manajemen-project/berita-acara-project/*') ? 'active' : ''}}">
                            <a href="{{ url('manajemen-project/berita-acara-project') }}">Berita Acara Project</a>
                        </li>
                        <li class="{{ Request::is('manajemen-project/termin-pembayaran-project') ? 'active' : '' || Request::is('manajemen-project/termin-pembayaran-project/*') ? 'active' : ''}}">
                            <a href="{{ url('manajemen-project/termin-pembayaran-project') }}">Termin Pembayaran Project</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('manajemen-team/*') ? 'active' : '' }}">
                    <a href="javascript: void(0);" class=""><i class="fi-head"></i> <span> Manajemen Team </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="{{ Request::is('manajemen-team/daftar-team') ? 'active' : '' || Request::is('manajemen-team/daftar-team/*') ? 'active' : '' }}">
                            <a class="" href="{{ url('manajemen-team/daftar-team') }}">Daftar Team</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="javascript: void(0);" class=""><i class="fi-layers"></i> <span> Todo List </span> <span class="menu-arrow"></span></a>
                </li>
                <li class="">
                    <a href="javascript: void(0);" class=""><i class="fi fi-bar-graph-2"></i> <span>Keuangan</span> <span class="menu-arrow"></span></a>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->