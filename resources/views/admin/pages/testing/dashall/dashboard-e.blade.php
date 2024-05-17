@include('admin.includes.head')

<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
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
                                        %</span>) total kehadiran I/E</p>
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
                                        %</span>) total kehadiran Regular I/E</p>
                                <hr class="dark horizontal">
                                <div class="d-flex ">
                                    <i class="material-icons text-sm my-auto me-1">schedule</i>
                                    <p class="mb-0 text-sm"> last updated at ({{ $latest }}) </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">H</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Hadir</p>
                                    <h4 class="mb-0">{{ $reg_h_dept }}
                                        ({{ ($reg_h_dept != null) ? number_format(($reg_h_dept / $budget_reg_dept) * 100, 1) : 0 }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate <strong style="float: right">{{ $to_reg_h }}
                                        ({{ number_format($per_tot_reg_h, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">M</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Mangkir</p>
                                    <h4 class="mb-0">{{ $reg_ta_dept }}
                                        ({{ ($reg_ta_dept != null) ? number_format(($reg_ta_dept / $budget_reg_dept) * 100, 1) : 0}}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate <strong style="float: right">{{ $to_reg_a }}
                                        ({{ number_format($per_tot_reg_a, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">MX</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Mangkir (Hari Libur)</p>
                                    <h4 class="mb-0">{{ $reg_mx_dept }}
                                        ({{ ($reg_mx_dept != null) ? number_format(($reg_mx_dept / $budget_reg_dept) * 100, 1) : 0 }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate <strong style="float: right">{{ $to_reg_mx }}
                                        ({{ number_format($per_tot_reg_mx, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">L</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Lambat</p>
                                    <h4 class="mb-0">{{ $reg_ta_dept }}
                                        ({{ ($reg_ta_dept != null) ? number_format(($reg_ta_dept / $budget_reg_dept) * 100, 1) : 0}}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate <strong style="float: right">{{ $to_reg_a }}
                                        ({{  number_format($per_tot_reg_a, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">D</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Dinas</p>
                                    <h4 class="mb-0">{{ $reg_d_dept }}
                                        ({{ ($reg_d_dept != null) ? number_format(($reg_d_dept / $budget_reg_dept) * 100, 1) : 0 }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_d }}
                                        ({{ ($to_reg_d != null) ? number_format(($to_reg_d / $tot_reg) * 100, 1) : 0}} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">E</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Early (Pulang Cepat)</p>
                                    <h4 class="mb-0">{{ $reg_e_dept }}
                                        ({{ ($reg_e_dept != null) ? number_format(($reg_e_dept / $budget_reg_dept) * 100, 1) : 0 }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_e }}
                                        ({{ ($to_reg_e != null) ? number_format(($to_reg_e / $tot_reg) * 100, 1) : 0  }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">I</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Izin</p>
                                    <h4 class="mb-0">{{ $reg_i_dept }}
                                        ({{ ($reg_i_dept != null) ? number_format(($reg_i_dept / $budget_reg_dept) * 100, 1) : 0 }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_i }}
                                        ({{ ($to_reg_i) ? number_format(($to_reg_i / $tot_reg) * 100, 1) : 0}} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">S</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Sakit</p>
                                    <h4 class="mb-0">{{ $reg_s_dept }}
                                        ({{ ($reg_s_dept != null) ? number_format(($reg_s_dept / $budget_reg_dept) * 100, 1) : 0}}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_s }}
                                        ({{ ($to_reg_s != null) ? number_format(($to_reg_s / $tot_reg) * 100, 1) : 0 }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">C</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Cuti</p>
                                    <h4 class="mb-0">{{ $reg_c_dept }}
                                        ({{ ($reg_c_dept != null) ? number_format(($reg_c_dept / $budget_reg_dept) * 100, 1) : 0}}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_c }}
                                        ({{ ($to_reg_c != null) ? number_format(($to_reg_c / $tot_reg) * 100, 1) : 0 }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">IX</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Izin Tidak Dibayar</p>
                                    <h4 class="mb-0">{{ $reg_ix_dept }}
                                        ({{ ($reg_ix_dept != null) ? number_format(($reg_ix_dept / $budget_reg_dept) * 100, 1) : 0 }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_ix }}
                                        ({{ ($to_reg_ix != null) ? number_format(($to_reg_ix / $tot_reg) * 100, 1) : 0}} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <h2 class="mt-2 text-white">SX</h2>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Sakit Tidak Dibayar</p>
                                    <h4 class="mb-0">{{ $reg_sx_dept }}
                                        ({{ ($reg_sx_dept != null) ? number_format(($reg_sx_dept / $budget_reg_dept) * 100, 1) : 0 }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_sx }}
                                        ({{ ($to_reg_sx) ? number_format(($to_reg_sx / $tot_reg) * 100, 1) : 0}} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">

                    <div class="col-lg mt-4">
                        <div class="card z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 my-3 z-index-2 bg-transparent"
                                style="background-color: white !important;">
                                {{-- <div class="bg shadow border-radius-lg py-3 pe-1">
                                    <div class="chart">
                                        <canvas id="chart-ket-dept" class="chart-canvas" height="100"></canvas>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="card-body">
                                <h6 class="mb-0 "> Kehadiran Harian </h6>
                                <p class="text-sm "> (<span
                                        class="font-weight-bolder">{{ number_format($t_dept, 1) }}
                                        %</span>) total kehadiran Regular Sub Divisi I/E</p>

                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-striped table-responsive table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" colspan="4">Riwayat Tidak Hadir Sub
                                                        Divisi I/E ( {{ $date }} )</th>
                                                </tr>
                                                <tr>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Posisi</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($kondisi > 0)
                                                    @forelse ($list_absen_reg as $item)
                                                        <tr>
                                                            <td>{{ $item->user->nik }}</td>
                                                            <td>{{ $item->user->name }}</td>
                                                            <td>{{ $item->user->jabatan }}</td>
                                                            <td>{{ $item->desc }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td class="text-center" colspan="4">
                                                                <h5>Belum ada data</h5>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                @else
                                                    <tr>
                                                        <td colspan="4">
                                                            <h6 class="text-center">Belum ada data</h6>
                                                        </td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

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
                                        <canvas id="chart-ket-dept-todate" class="chart-canvas"
                                            height="120"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-0 ">Todate Kehadiran Harian Sub Divisi I/E </h6>
                                <p class="text-sm "> (<span
                                        class="font-weight-bolder">{{ number_format($per_tot_reg_h, 1) }}
                                        %</span>) total Todate Kehadiran Regular Sub Divisi I/E</p>
                                <hr class="dark horizontal">
                                <div class="d-flex ">
                                    <i class="material-icons text-sm my-auto me-1">schedule</i>
                                    <p class="mb-0 text-sm"> last updated at ({{ $latest }}) </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin.includes.footer')
            </div>
    </main>
    @include('admin.includes.script')

    <style>
        #ww {
            color: rgba(255, 0, 0, 0.367);
        }
    </style>

    <script>
        var ctx = document.getElementById("chart-kehadiran").getContext('2d');
        var myChart = new Chart(ctx, {

            type: 'line',
            data: {
                labels: ["Monthly", "Staff", "Regular"],
                datasets: [{
                        label: 'Actual',
                        data: [{{ $monthly }}, {{ $staff }}, {{ $regular }}
                        ],
                        borderWidth: 1,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgb(75, 192, 192)',
                    },
                    {
                        label: 'Target',
                        data: [{{ $budget_monthly }}, {{ $budget_staff }}, {{ $budget_regular }}
                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Kehadiran per {{ $date }}'
                },
                layout: {
                    padding: 30
                }
            }

        });
    </script>
    <script>
        var ctx1 = document.getElementById("chart-ket").getContext('2d');
        var myChart1 = new Chart(ctx1, {
            plugins: [ChartDataLabels],
            type: 'bar',
            data: {
                labels: ["I/E"],
                datasets: [{
                        label: 'Hadir',
                        data: [
                            {{ $reg_h }}
                        ],
                        borderWidth: 1,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgb(75, 192, 192)',
                    },
                    {
                        label: 'Mangkir',
                        data: [{{ $reg_a }}
                        ],
                        borderWidth: 1,
                        borderColor: '#F4BFBF',
                        backgroundColor: '#F4BFBF',
                    },
                    {
                        label: 'Mangkir (Hari Libur)',
                        data: [{{ $reg_mx }}
                        ],
                        borderWidth: 1,
                        borderColor: '#F4BFBF',
                        backgroundColor: '#F4BFBF',
                    },
                    {
                        label: 'Lambat',
                        data: [{{ $reg_l }}
                        ],
                        borderWidth: 1,
                        borderColor: '#F4BFBF',
                        backgroundColor: '#F4BFBF',
                    },
                    {
                        label: 'Dinas',
                        data: [{{ $reg_d }}
                        ],
                        borderWidth: 1,
                        borderColor: '#FFD9C0',
                        backgroundColor: '#FFD9C0',
                    },
                    {
                        label: 'Early (Pulang Cepat)',
                        data: [{{ $reg_e }}
                        ],
                        borderWidth: 1,
                        borderColor: '#FAF0D7',
                        backgroundColor: '#FAF0D7',
                    },
                    {
                        label: 'Izin',
                        data: [{{ $reg_i }}
                        ],
                        borderWidth: 1,
                        borderColor: '#8CC0DE',
                        backgroundColor: '#8CC0DE',
                    },
                    {
                        label: 'Sakit',
                        data: [{{ $reg_s }}
                        ],
                        borderWidth: 1,
                        borderColor: '#C1EFFF',
                        backgroundColor: '#C1EFFF',
                    },
                    {
                        label: 'Cuti',
                        data: [{{ $reg_c }}
                        ],
                        borderWidth: 1,
                        borderColor: '#C1EFFF',
                        backgroundColor: '#C1EFFF',
                    },
                    {
                        label: 'Izin Tidak Dibayar',
                        data: [{{ $reg_ix }}
                        ],
                        borderWidth: 1,
                        borderColor: '#C1EFFF',
                        backgroundColor: '#C1EFFF',
                    },
                    {
                        label: 'Sakit Tidak Dibayar',
                        data: [{{ $reg_sx }}
                        ],
                        borderWidth: 1,
                        borderColor: '#C1EFFF',
                        backgroundColor: '#C1EFFF',
                    }
                ]
            },
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,

                layout: {
                    padding: 30
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: Math.round,
                        font: {
                            weight: 'bold'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Kehadiran Regular per {{ $date }}'
                    },
                }
            }

        });
    </script>
    <script>
        var ctx1 = document.getElementById("chart-ket-dept").getContext('2d');
        var myChart1 = new Chart(ctx1, {
            plugins: [ChartDataLabels],
            type: 'bar',
            data: {
                labels: ["Hadir",  "Mangkir", "Mangkir (Hari Libur)", "Lambat", "Dinas", "Early (Pulang Cepat)", "Izin", "Sakit", "Cuti",
                    "Izin Tidak Dibayar", "Sakit Tidak Dibayar"
                ],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                        {{ $reg_h_dept }}, {{ $reg_ta_dept }}, {{ $reg_mx_dept }}, {{ $reg_l_dept }},{{ $reg_d_dept }},
                        {{ $reg_e_dept }}, {{ $reg_i_dept }}, {{ $reg_s_dept }},
                        {{ $reg_c_dept }}, {{ $reg_ix_dept }}, {{ $reg_sx_dept }}
                    ],
                    borderWidth: 1,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgb(75, 192, 192)',
                }, ]
            },
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,

                layout: {
                    padding: 30
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: Math.round,
                        font: {
                            weight: 'bold'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Kehadiran Regular per {{ $date }} Sub Divisi I/E'
                    },
                }
            }

        });
    </script>
    <script>
        var ctx1 = document.getElementById("chart-ket-dept-todate").getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: [{{ $day }}],
                datasets: [
                    {
                        label: "Mangkir",
                        data: [
                            {{ $reg_a_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#F675A8',
                    },
                    {
                        label: "Mangkir (Hari Libur)",
                        data: [
                            {{ $reg_mx_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#F675A8',
                    },
                    {
                        label: "Late (Lambat)",
                        data: [
                            {{ $reg_l_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#FFDBA4',
                    },
                    {
                        label: "Dinas",
                        data: [
                            {{ $reg_d_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#AC7088',
                    },
                    {
                        label: "Early (Pulang Cepat)",
                        data: [
                            {{ $reg_e_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#AF7AB3',
                    },
                    {
                        label: "Izin",
                        data: [
                            {{ $reg_i_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#F5F0BB',
                    },
                    {
                        label: "Sakit",
                        data: [
                            {{ $reg_s_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#9A86A4',
                    },
                    {
                        label: "Cuti",
                        data: [
                            {{ $reg_c_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#E6BA95',
                    },
                    {
                        label: "Izin Tidak Dibayar",
                        data: [
                            {{ $reg_ix_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#FFB2A6',
                    },
                    {
                        label: "Sakit Tidak Dibayar",
                        data: [
                            {{ $reg_sx_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#FF8AAE',
                    },
                ]
            },
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    },
                    line: {
                        tension: 0.4
                    }
                },
                responsive: true,

                layout: {
                    padding: 30
                },
                plugins: {

                    title: {
                        display: true,
                        text: 'Todate Kehadiran Regular per {{ $date }} Sub Divisi I/E'
                    },
                }
            }

        });
    </script>
</body>
