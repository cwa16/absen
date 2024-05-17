@include('admin.includes.head')
<style>
    #table-data th,
    #table-data td {
        border: 1px solid #282d3a;
        padding: 3px;
        text-align: center;
    }

    #table-data thead {
        background-color: #f2f0e9;
    }

    #table-data th {
        background-color: #f2f0e9;
        border: 1px solid #282d3a;
    }

    #table-data tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
        @if (Auth::user()->role_app == 'Admin')
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">person</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Monthly</p>
                                    <h4 class="mb-0">{{ $monthly }}/{{ $budget_monthly }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span> Today's
                                    Attendance <strong style="float: right">{{ number_format($per_monthly, 1) }}
                                        %</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">person</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Staff</p>
                                    <h4 class="mb-0">{{ $staff }}/{{ $budget_staff }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span> Today's
                                    Attendance <strong style="float: right">{{ number_format($per_staff, 1) }}
                                        %</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">person</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Manager</p>
                                    <h4 class="mb-0">{{ $manager }}/{{ $budget_manager }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder"></span> Today's
                                    Attendance <strong style="float: right">{{ number_format($per_manager, 1) }}
                                        %</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">person</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Regular</p>
                                    <h4 class="mb-0">{{ $regular }}/{{ $budget_regular }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span> Today's
                                    Attendance <strong style="float: right">{{ number_format($per_regular, 1) }}
                                        %</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg mt-4">
                        <div class="card z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent"
                                style="background-color: white !important;">
                                <div class="bg shadow border-radius-lg py-3 pe-1">
                                    <div class="chart">
                                        <canvas id="chart-kehadiran" class="chart-canvas" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-0 "> Kehadiran Harian </h6>
                                <p class="text-sm "> (<span
                                        class="font-weight-bolder">{{ number_format($per_total, 1) }}
                                        %</span>) total kehadiran BSKP</p>
                                <hr class="dark horizontal">
                                <div class="d-flex ">
                                    <i class="material-icons text-sm my-auto me-1">schedule</i>
                                    <p class="mb-0 text-sm"> last updated at ({{ $latest }}) </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">

                    <div class="col-lg mt-4">
                        <div class="card z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent"
                                style="background-color: white !important;">
                                <div class="bg shadow border-radius-lg py-3 pe-1">
                                    <div class="chart">
                                        <canvas id="chart-ket" class="chart-canvas" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-0 "> Kehadiran Harian </h6>
                                <p class="text-sm "> (<span
                                        class="font-weight-bolder">{{ number_format($per_regular, 1) }}
                                        %</span>) total kehadiran Regular BSKP</p>
                                <hr class="dark horizontal">
                                <div class="d-flex ">
                                    <i class="material-icons text-sm my-auto me-1">schedule</i>
                                    <p class="mb-0 text-sm"> last updated at ({{ $latest }}) </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer py-4  ">
                    <div class="container-fluid">
                        <div class="row align-items-center justify-content-lg-between">
                            <div class="col-lg-6 mb-lg-0 mb-4">
                                <div class="copyright text-center text-sm text-muted text-lg-start">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script>,
                                    made with <i class="fa fa-heart"></i> by
                                    <a href="https://www.creative-tim.com" class="font-weight-bold"
                                        target="_blank">Creative Tim</a>
                                    for a better web.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com" class="nav-link text-muted"
                                            target="_blank">Creative Tim</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/presentation"
                                            class="nav-link text-muted" target="_blank">About Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                            target="_blank">Blog</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/license"
                                            class="nav-link pe-0 text-muted" target="_blank">License</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        @else
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3><strong>Kehadiran Karyawan {{ $dept }}</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Dept: {{ $dept }}</h4>
                                <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                            </div>
                        </div>
                        <table class="table" id="table-data">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Mandor</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Status</th>
                                    <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Total<br>TK</th>
                                    <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Hadir<br>(H)</th>
                                    <th rowspan="2" style="padding-left:8px;padding-right:8px;width: 80px;">TA</th>
                                    <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Dinas<br>(D)</th>
                                    <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Lambat<br>(L)<br>Day</th>
                                    <th colspan="2">Mangkir (M)</th>
                                    <th colspan="2">Sakit (S)</th>
                                    <th colspan="3">Ijin (I)</th>
                                    <th colspan="4">Cuti (C)</th>
                                </tr>
                                <tr>
                                    <th style="padding-left:8px;padding-right:8px;width: 80px;">M</th>
                                    <th style="width: 80px;">MX</th>
                                    <th style="padding-left:8px;padding-right:8px;width: 80px;">S</th>
                                    <th style="width: 80px;">SX</th>
                                    <th style="padding-left:16px;padding-right:16px;width: 80px;">I</th>
                                    <th style="padding-left:12px;padding-right:12px;width: 80px;">IP</th>
                                    <th style="padding-left:12px;padding-right:12px;width: 80px;">IX</th>
                                    <th style="width: 80px;">CT</th>
                                    <th style="width: 80px;">CH</th>
                                    <th style="width: 80px;">CB</th>
                                    <th style="width: 80px;">CL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($data as $item)
                                    <tr class="text-left">
                                        <td rowspan="4" style="text-align: center; vertical-align: middle;">{{ $counter++ }}</td>
                                        <form action="{{ route('summary-per-dept-mandor-per-emp') }}" method="POST">
                                            @csrf
                                            <td rowspan="4" class="text-left">
                                                <br>
                                                <input type="hidden" name="mandor_nik" value="{{ $item['mandor'] }}">
                                                <input type="hidden" name="date" value="{{ $item['date'] }}">
                                                <input type="hidden" name="dept" value="{{ $item['dept'] }}">
                                                {{ $item['mandorName'] }}
                                                <br><button class="btn btn-primary btn-sm" type="submit">Detail</button>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <td class="text-left text-bold">Reg</td>
                                        <td>{{ $item['regularTotal1'] }}</td>
                                        <td>{{ $item['totalHFinalReg'] }}</td>
                                        <td>{{ $item['totalTAFinalReg'] }}</td>
                                        <td>{{ $item['totalDFinalReg'] }}</td>
                                        <td>{{ $item['totalLFinalReg'] }}</td>
                                        <td>{{ $item['totalMFinalReg'] }}</td>
                                        <td>{{ $item['totalMXFinalReg'] }}</td>
                                        <td>{{ $item['totalSFinalReg'] }}</td>
                                        <td>{{ $item['totalSXFinalReg'] }}</td>
                                        <td>{{ $item['totalIFinalReg'] }}</td>
                                        <td>{{ $item['totalIPFinalReg'] }}</td>
                                        <td>{{ $item['totalIXFinalReg'] }}</td>
                                        <td>{{ $item['totalCTFinalReg'] }}</td>
                                        <td>{{ $item['totalCHFinalReg'] }}</td>
                                        <td>{{ $item['totalCBFinalReg'] }}</td>
                                        <td>{{ $item['totalCLFinalReg'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left text-bold">FL</td>
                                        <td>{{ $item['flTotal1'] }}</td>
                                        <td>{{ $item['totalHFinalFl'] }}</td>
                                        <td>{{ $item['totalTAFinalFl'] }}</td>
                                        <td>{{ $item['totalDFinalFl'] }}</td>
                                        <td>{{ $item['totalLFinalFl'] }}</td>
                                        <td>{{ $item['totalMFinalFl'] }}</td>
                                        <td>{{ $item['totalMXFinalFl'] }}</td>
                                        <td>{{ $item['totalSFinalFl'] }}</td>
                                        <td>{{ $item['totalSXFinalFl'] }}</td>
                                        <td>{{ $item['totalIFinalFl'] }}</td>
                                        <td>{{ $item['totalIPFinalFl'] }}</td>
                                        <td>{{ $item['totalIXFinalFl'] }}</td>
                                        <td>{{ $item['totalCTFinalFl'] }}</td>
                                        <td>{{ $item['totalCHFinalFl'] }}</td>
                                        <td>{{ $item['totalCBFinalFl'] }}</td>
                                        <td>{{ $item['totalCLFinalFl'] }}</td>
                                    </tr>
                                    <tr style="background-color: #ffff99;">
                                        <td class="text-left text-bold">Total</td>
                                        <td>{{ $item['regularTotal1'] + $item['flTotal1'] }}</td>
                                        <td>{{ $item['totalHFinalReg'] + $item['totalHFinalFl'] }}</td>
                                        <td>{{ $item['totalTAFinalReg'] + $item['totalTAFinalFl'] }}</td>
                                        <td>{{ $item['totalDFinalReg'] + $item['totalDFinalFl'] }}</td>
                                        <td>{{ $item['totalLFinalReg'] + $item['totalLFinalFl'] }}</td>
                                        <td>{{ $item['totalMFinalReg'] + $item['totalMFinalFl'] }}</td>
                                        <td>{{ $item['totalMXFinalReg'] + $item['totalMXFinalFl'] }}</td>
                                        <td>{{ $item['totalSFinalReg'] + $item['totalSFinalFl'] }}</td>
                                        <td>{{ $item['totalSXFinalReg'] + $item['totalSXFinalFl'] }}</td>
                                        <td>{{ $item['totalIFinalReg'] + $item['totalIFinalFl'] }}</td>
                                        <td>{{ $item['totalIPFinalReg'] + $item['totalIPFinalFl'] }}</td>
                                        <td>{{ $item['totalIXFinalReg'] + $item['totalIXFinalFl'] }}</td>
                                        <td>{{ $item['totalCTFinalReg'] + $item['totalCTFinalFl'] }}</td>
                                        <td>{{ $item['totalCHFinalReg'] + $item['totalCHFinalFl'] }}</td>
                                        <td>{{ $item['totalCBFinalReg'] + $item['totalCBFinalFl'] }}</td>
                                        <td>{{ $item['totalCLFinalReg'] + $item['totalCLFinalFl'] }}</td>
                                    </tr>
                                @endforeach
                                <tr></tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td rowspan="4"></td>
                                    <td rowspan="4" style="text-align: center; vertical-align: middle;">Total</td>
                                </tr>
                                <tr>
                                    <td class="text-left text-bold">Reg</td>
                                    <td>{{ $totalRegularTotal1 }}</td>
                                    <td>{{ $totalHTotalReg }}</td>
                                    <td>{{ $totalTATotalReg }}</td>
                                    <td>{{ $totalDTotalReg }}</td>
                                    <td>{{ $totalLTotalReg }}</td>
                                    <td>{{ $totalMTotalReg }}</td>
                                    <td>{{ $totalMXTotalReg }}</td>
                                    <td>{{ $totalSTotalReg }}</td>
                                    <td>{{ $totalSXTotalReg }}</td>
                                    <td>{{ $totalITotalReg }}</td>
                                    <td>{{ $totalIPTotalReg }}</td>
                                    <td>{{ $totalIXTotalReg }}</td>
                                    <td>{{ $totalCTTotalReg }}</td>
                                    <td>{{ $totalCHTotalReg }}</td>
                                    <td>{{ $totalCBTotalReg }}</td>
                                    <td>{{ $totalCLTotalReg }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left text-bold">FL</td>
                                    <td>{{ $totalFlTotal1 }}</td>
                                    <td>{{ $totalHTotalFl }}</td>
                                    <td>{{ $totalTATotalFl }}</td>
                                    <td>{{ $totalDTotalFl }}</td>
                                    <td>{{ $totalLTotalFl }}</td>
                                    <td>{{ $totalMTotalFl }}</td>
                                    <td>{{ $totalMXTotalFl }}</td>
                                    <td>{{ $totalSTotalFl }}</td>
                                    <td>{{ $totalSXTotalFl }}</td>
                                    <td>{{ $totalITotalFl }}</td>
                                    <td>{{ $totalIPTotalFl }}</td>
                                    <td>{{ $totalIXTotalFl }}</td>
                                    <td>{{ $totalCTTotalFl }}</td>
                                    <td>{{ $totalCHTotalFl }}</td>
                                    <td>{{ $totalCBTotalFl }}</td>
                                    <td>{{ $totalCLTotalFl }}</td>
                                </tr>
                                <tr style="background-color: #ffff99;">
                                    <td class="text-left text-bold">Total</td>
                                    <td>{{ $totalRegularTotal1 + $totalFlTotal1 }}</td>
                                    <td>{{ $totalHTotalReg + $totalHTotalFl }}</td>
                                    <td>{{ $totalTATotalReg + $totalTATotalFl }}</td>
                                    <td>{{ $totalDTotalReg + $totalDTotalFl }}</td>
                                    <td>{{ $totalLTotalReg + $totalLTotalFl }}</td>
                                    <td>{{ $totalMTotalReg + $totalMTotalFl }}</td>
                                    <td>{{ $totalMXTotalReg + $totalMXTotalFl }}</td>
                                    <td>{{ $totalSTotalReg + $totalSTotalFl }}</td>
                                    <td>{{ $totalSXTotalReg + $totalSXTotalFl }}</td>
                                    <td>{{ $totalITotalReg + $totalITotalFl }}</td>
                                    <td>{{ $totalIPTotalReg + $totalIPTotalFl }}</td>
                                    <td>{{ $totalIXTotalReg + $totalIXTotalFl }}</td>
                                    <td>{{ $totalCTTotalReg + $totalCTTotalFl }}</td>
                                    <td>{{ $totalCHTotalReg + $totalCHTotalFl }}</td>
                                    <td>{{ $totalCBTotalReg + $totalCBTotalFl }}</td>
                                    <td>{{ $totalCLTotalReg + $totalCLTotalFl }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @include('admin.includes.footer')
            </div>
        @endif
    </main>
    @include('admin.includes.script')
</body>
