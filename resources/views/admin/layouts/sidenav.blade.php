<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
            target="_blank">
            <img src="{{ asset('assets/img/bs.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">BSKP Attendance</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main"
        style="margin-top:-5px;padding-bottom:670px;">
        <ul class="navbar-nav">
            {{-- <li class="nav-item">
                <a class="nav-link text-white active bg-gradient-primary" href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-gauge"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-gauge"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- Dashboard --}}
            {{-- @if (Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'BSKP' || Auth::user()->role_app == 'Admin')
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('dashboard-regular-admin') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-gauge"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard Regular</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('dashboard-cuti') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-gauge"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard Cuti</span>
                    </a>
                </li>
            @endif --}}

            {{-- Menu Input Kehadiran Manual --}}
            @if (Auth::user()->dept == 'HR Legal')

                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Input</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('attendance-input') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-sharp fa-solid fa-keyboard"></i>
                        </div>
                        <span class="nav-link-text ms-1">Input Kehadiran - Manual</span>
                    </a>
                </li>
            @endif

            {{-- Menu Input Kehadiran Regular --}}
            @if (Auth::user()->role_app == 'Inputer' || Auth::user()->role_app == 'Admin')
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('absen-regular') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-sharp fa-solid fa-keyboard"></i>
                        </div>
                        <span class="nav-link-text ms-1">Input Kehadiran - Regular</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'BSKP')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Kemandoran
                    </h6>
                </li>
                <li class="nav-item mt-3">
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('kemandoran') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-keyboard"></i>
                        </div>
                        <span class="nav-link-text ms-1">Input Kemandoran</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->dept == 'MFO')
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('attendance-approval') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-check-to-slot"></i>
                        </div>
                        <span class="nav-link-text ms-1">Check - Div. Manager</span>
                    </a>
                </li>
            @endif


            @if (Auth::user()->dept == 'MFO')
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('attendance-approval') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-check-to-slot"></i>
                        </div>
                        <span class="nav-link-text ms-1">Approval</span>
                    </a>
                </li>
            @endif

            {{-- @if (Auth::user()->dept == 'HR Legal')
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('attendance-checked') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-check-to-slot"></i>
                        </div>
                        <span class="nav-link-text ms-1">Check - HRD</span>
                    </a>
                </li>
            @endif --}}

            {{-- Menu User --}}
            @if (Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'HR & Legal')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Master</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('user-master') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Master Pengguna</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('master-employee') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-person"></i>
                    </div>
                    <span class="nav-link-text ms-1">Master Employee</span>
                </a>
            </li>

            @if (Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'HR & Legal')
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('master-absen') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <span class="nav-link-text ms-1">Master Absen</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('holiday') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <span class="nav-link-text ms-1">Master Hari Libur</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('master-work-hour') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <span class="nav-link-text ms-1">Master Jam Kerja</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('work-hour') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <span class="nav-link-text ms-1">Buat Jam Kerja</span>
                </a>
            </li>
            @endif

            {{-- Data Training --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Personal Data</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('master-training') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-note-sticky"></i>
                    </div>
                    <span class="nav-link-text ms-1">Data Training</span>
                </a>
            </li>

            {{-- Menu Medical, Narkoba, dan Hari Libur --}}
            @if (Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'HR & Legal')
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('medical') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-notes-medical"></i>
                        </div>
                        <span class="nav-link-text ms-1">Data Medical</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('drug') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-pills"></i>
                        </div>
                        <span class="nav-link-text ms-1">Data Narkoba</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('holiday-all-dept') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <span class="nav-link-text ms-1">Hari Libur All Dept</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Cuti</h6>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('budget-cuti') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-brands fa-stack-exchange"></i>
                        </div>
                        <span class="nav-link-text ms-1">Budget Cuti</span>
                    </a>
                </li> --}}
            @endif

            {{-- Input Cuti --}}
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('cuti') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-keyboard"></i>
                    </div>
                    <span class="nav-link-text ms-1">Input Cuti</span>
                </a>
            </li>

            @if (Auth::user()->role_app == 'Inputer' && Auth::user()->role_app == 'Admin')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Kemandoran
                    </h6>
                </li>
                <li class="nav-item mt-3">
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('kemandoran') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-keyboard"></i>
                        </div>
                        <span class="nav-link-text ms-1">Input Kemandoran</span>
                    </a>
                </li>
            @endif

            {{-- Menu Summary Kehadiran --}}
            @if (Auth::user()->role_app == 'Inputer' || Auth::user()->role_app == 'Admin')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Summary</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('testing') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-table-list"></i>
                        </div>
                        <span class="nav-link-text ms-1">Kehadiran All Emp</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('summary-per-dept-reg-new') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-table-list"></i>
                        </div>
                        <span class="nav-link-text ms-1">Laporan Kehadiran Detail</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('summary-kategori-new') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-regular fa-table"></i>
                        </div>
                        <span class="nav-link-text ms-1">Summary Kategori</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('summary-per-dept-filter-dept') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-regular fa-table"></i>
                        </div>
                        <span class="nav-link-text ms-1">Summary Per Dept</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('attendance') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-table-columns"></i>
                        </div>
                        <span class="nav-link-text ms-1">Grafik Summary Kehadiran</span>
                    </a>
                </li> --}}
            @endif

            {{-- Menu Shift --}}
            @if (Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'BSKP')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Shift
                    </h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('shift-master') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <span class="nav-link-text ms-1">Master Shift</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('shift-setting') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pengaturan Shift</span>
                    </a>
                </li>
            @endif

            {{-- Menu Pengaturan Shift --}}
            @if (Auth::user()->dept == 'Factory' || Auth::user()->dept == 'Security')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Shift
                    </h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('shift-setting') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pengaturan Shift</span>
                    </a>
                </li>
            @endif

            {{-- Testing Pages Menu --}}
            @if (Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'HR & Legal')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Testing pages
                    </h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('dashboard-all') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-gauge"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard All Dept</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('testing.dash') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-gauge"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard Testing</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('sum-month') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-comment-slash"></i>
                        </div>
                        <span class="nav-link-text ms-1">Report Attendance</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('index-mail-batch') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-comment-slash"></i>
                        </div>
                        <span class="nav-link-text ms-1">Send Mail</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('table_att_data') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-comment-slash"></i>
                        </div>
                        <span class="nav-link-text ms-1">Emp Att Table</span>
                    </a>
                </li>
            @endif

            {{-- @if (Auth::user()->dept == 'Factory')
            <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Testing pages
                    </h6>
                </li>
            <li class="nav-item">
                    <a class="nav-link text-white " href="{{ route('change-ta-desc') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-comment-slash"></i>
                        </div>
                        <span class="nav-link-text ms-1">TA Attendance</span>
                    </a>
                </li>
            @endif --}}

        </ul>
    </div>

</aside>
