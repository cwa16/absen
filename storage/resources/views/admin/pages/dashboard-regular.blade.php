@include('admin.includes.head')

<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
            <div class="container-fluid py-4">
                {{-- <div class="row">
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">`</p>
                                    <h4 class="mb-0">{{ $reg_h_dept }}
                                        ({{ number_format(($reg_h_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
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
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Mangkir <strong>(M)</strong></p>
                                    <h4 class="mb-0">{{ $reg_ta_dept }}
                                        ({{ number_format(($reg_ta_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
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
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Mangkir (Hari Libur) <strong>(MX)</strong></p>
                                    <h4 class="mb-0">{{ $reg_mx_dept }}
                                        ({{ number_format(($reg_mx_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
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
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Lambat <strong>(L)</strong></p>
                                    <h4 class="mb-0">{{ $reg_ta_dept }}
                                        ({{ number_format(($reg_ta_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
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
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Dinas <strong>(D)</strong></p>
                                    <h4 class="mb-0">{{ $reg_d_dept }}
                                        ({{ number_format(($reg_d_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_d }}
                                        ({{ number_format(($to_reg_d / $tot_reg) * 100, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Early (Pulang Cepat) <strong>(E)</strong></p>
                                    <h4 class="mb-0">{{ $reg_e_dept }}
                                        ({{ number_format(($reg_e_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_e }}
                                        ({{ number_format(($to_reg_e / $tot_reg) * 100, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Izin <strong>(I)</strong></p>
                                    <h4 class="mb-0">{{ $reg_i_dept }}
                                        ({{ number_format(($reg_i_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_i }}
                                        ({{ number_format(($to_reg_i / $tot_reg) * 100, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mb-xl-0 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Sakit <strong>(S)</strong></p>
                                    <h4 class="mb-0">{{ $reg_s_dept }}
                                        ({{ number_format(($reg_s_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_s }}
                                        ({{ number_format(($to_reg_s / $tot_reg) * 100, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Cuti <strong>(C)</strong></p>
                                    <h4 class="mb-0">{{ $reg_c_dept }}
                                        ({{ number_format(($reg_c_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_c }}
                                        ({{ number_format(($to_reg_c / $tot_reg) * 100, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Izin Tidak Dibayar <strong>(IX)</strong></p>
                                    <h4 class="mb-0">{{ $reg_ix_dept }}
                                        ({{ number_format(($reg_ix_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_ix }}
                                        ({{ number_format(($to_reg_ix / $tot_reg) * 100, 1) }} %)</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 mt-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Sakit Tidak Dibayar <strong>(SX)</strong></p>
                                    <h4 class="mb-0">{{ $reg_sx_dept }}
                                        ({{ number_format(($reg_sx_dept / $budget_reg_dept) * 100, 1) }}%)</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                    Todate<strong style="float: right">{{ $to_reg_sx }}
                                        ({{ number_format(($to_reg_sx / $tot_reg) * 100, 1) }} %)</strong>
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
                            </div>
                            <div class="card-body">
                                <h6 class="mb-0 mt-3"> Kehadiran Harian ({{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d-M-Y') }})</h6>
                                <p class="text-sm "> (<span
                                        class="font-weight-bolder">{{ number_format($t_dept, 1) }}
                                        %</span>) total kehadiran Regular BSKP</p>

                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-striped table-responsive table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" colspan="5">Riwayat Tidak Hadir BSKP
                                                </tr>
                                                <tr>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Posisi</th>
                                                    <th>Sub Divisi</th>
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
                                                        <td>{{ $item->user->dept }}</td>
                                                        <td>{{ $item->desc }}</td>
                                                    </tr>

                                                    @empty
                                                        <tr>
                                                            <td class="text-center" colspan="5">
                                                                <h5>Belum ada data</h5>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                @else
                                                    <tr>
                                                        <td colspan="5">
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
                                <h6 class="mb-0 ">Todate Kehadiran Harian BSKP</h6>
                                <p class="text-sm "> (<span
                                        class="font-weight-bolder">{{ number_format($per_tot_reg_h, 1) }}
                                        %</span>) total Todate Kehadiran Regular BSKP</p>
                                <hr class="dark horizontal">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('filter-todate') }}" method="post">
                                        @csrf
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Select Departement</td>
                                                <td>
                                                    <select class="form-control" name="dept" id="">
                                                       @foreach ($listDept as $item)
                                                           <option value="{{ $item->dept }}">{{ $item->dept }}</option>
                                                       @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary">Filter</button>
                                                </td>
                                            </tr>
                                        </table>
                                        </form>

                                        <table class="table table-striped table-bordered table-responsive table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" colspan="12">Todate Tidak Hadir BSKP
                                                </tr>
                                                <tr>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Posisi</th>
                                                    <th>Sub Divisi</th>
                                                    <th>Kemandoran</th>
                                                    <th>M</th>
                                                    <th>MX</th>
                                                    <th>I</th>
                                                    <th>IX</th>
                                                    <th>S</th>
                                                    <th>SX</th>
                                                    <th>C</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($kondisi > 0)
                                                    @forelse ($list_absen_reg_todate as $item)
                                                    @foreach ($item->mandor as $itemx)
                                                        <tr>
                                                        <td>{{ $item->nik }}</td>
                                                        <td>{{ $item->name}}</td>
                                                        <td>{{ $item->jabatan }}</td>
                                                        <td>{{ $item->dept }}</td>
                                                        <td>{{ $itemx->user->name }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'M')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'MX')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'I')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'IX')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'S')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'SX')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'C')->count() }}</td>

                                                    </tr>
                                                    @endforeach


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
                                        <tfoot class="mt-3"> {{ $list_absen_reg_todate->withQueryString()->links() }}</tfoot>
                                    </div>
                                </div>
                                <div class="d-flex ">
                                    <i class="material-icons text-sm my-auto me-1">schedule</i>
                                    <p class="mb-0 text-sm"> last updated at ({{ $latest }}) </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
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
                labels: ["Monthly", "Staff", "Manager", "Regular"],
                datasets: [{
                        label: 'Actual',
                        data: [{{ $monthly }}, {{ $staff }}, {{ $manager }},
                            {{ $regular }}
                        ],
                        borderWidth: 1,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgb(75, 192, 192)',
                    },
                    {
                        label: 'Target',
                        data: [{{ $budget_monthly }}, {{ $budget_staff }}, {{ $budget_manager }},
                            {{ $budget_regular }}
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
                labels: ["I/A", "I/B", "I/C", "II/D", "II/E", "II/F"],
                datasets: [{
                        label: 'Hadir',
                        data: [
                            {{ $reg_h }}, {{ $reg_h_b }}, {{ $reg_h_c }},
                            {{ $reg_h_d }}, {{ $reg_h_e }}, {{ $reg_h_f }}
                        ],
                        borderWidth: 1,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgb(75, 192, 192)',
                    },
                    {
                        label: 'Mangkir',
                        data: [{{ $reg_a }}, {{ $reg_a_b }}, {{ $reg_a_c }},
                            {{ $reg_a_d }}, {{ $reg_a_e }}, {{ $reg_a_f }}
                        ],
                        borderWidth: 1,
                        borderColor: '#F4BFBF',
                        backgroundColor: '#F4BFBF',
                    },
                    {
                        label: 'Mangkir',
                        data: [{{ $reg_mx }}, {{ $reg_mx_b }}, {{ $reg_mx_c }},
                            {{ $reg_mx_d }}, {{ $reg_mx_e }}, {{ $reg_mx_f }}
                        ],
                        borderWidth: 1,
                        borderColor: '#F4BFBF',
                        backgroundColor: '#F4BFBF',
                    },
                    {
                        label: 'Lambat',
                        data: [{{ $reg_l }}, {{ $reg_l_b }}, {{ $reg_l_c }},
                            {{ $reg_l_d }}, {{ $reg_l_e }}, {{ $reg_l_f }}
                        ],
                        borderWidth: 1,
                        borderColor: '#F4BFBF',
                        backgroundColor: '#F4BFBF',
                    },
                    {
                        label: 'Dinas',
                        data: [{{ $reg_d }}, {{ $reg_d_b }}, {{ $reg_d_c }},
                            {{ $reg_d_d }}, {{ $reg_d_e }}, {{ $reg_d_f }}
                        ],
                        borderWidth: 1,
                        borderColor: '#FFD9C0',
                        backgroundColor: '#FFD9C0',
                    },
                    {
                        label: 'Early (Pulang Cepat)',
                        data: [{{ $reg_e }}, {{ $reg_e_b }}, {{ $reg_e_c }},
                            {{ $reg_e_d }}, {{ $reg_e_e }}, {{ $reg_e_f }}
                        ],
                        borderWidth: 1,
                        borderColor: '#FAF0D7',
                        backgroundColor: '#FAF0D7',
                    },
                    {
                        label: 'Izin',
                        data: [{{ $reg_i }}, {{ $reg_i_b }}, {{ $reg_i_c }},
                            {{ $reg_i_d }}, {{ $reg_i_e }}, {{ $reg_i_f }}
                        ],
                        borderWidth: 1,
                        borderColor: '#8CC0DE',
                        backgroundColor: '#8CC0DE',
                    },
                    {
                        label: 'Sakit',
                        data: [{{ $reg_s }}, {{ $reg_s_b }}, {{ $reg_s_c }},
                            {{ $reg_s_d }}, {{ $reg_s_e }}, {{ $reg_s_f }}
                        ],
                        borderWidth: 1,
                        borderColor: '#C1EFFF',
                        backgroundColor: '#C1EFFF',
                    },
                    {
                        label: 'Cuti',
                        data: [{{ $reg_c }}, {{ $reg_c_b }}, {{ $reg_c_c }},
                            {{ $reg_c_d }}, {{ $reg_c_e }}, {{ $reg_c_f }}
                        ],
                        borderWidth: 1,
                        borderColor: '#C1EFFF',
                        backgroundColor: '#C1EFFF',
                    },
                    {
                        label: 'Izin Tidak Dibayar',
                        data: [{{ $reg_ix }}, {{ $reg_ix_b }}, {{ $reg_ix_c }},
                            {{ $reg_ix_d }}, {{ $reg_ix_e }}, {{ $reg_ix_f }}
                        ],
                        borderWidth: 1,
                        borderColor: '#C1EFFF',
                        backgroundColor: '#C1EFFF',
                    },
                    {
                        label: 'Sakit Tidak Dibayar',
                        data: [{{ $reg_sx }}, {{ $reg_sx_b }}, {{ $reg_sx_c }},
                            {{ $reg_sx_d }}, {{ $reg_sx_e }}, {{ $reg_sx_f }}
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
                labels: ["Hadir", "Mangkir", "Mangkir Hari Libur", "Lambat", "Dinas", "Early (Pulang Cepat)", "Izin", "Sakit", "Cuti",
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
                        text: 'Kehadiran Regular per {{ $date }} BSKP'
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
                        label: "Mankir",
                        data: [
                            {{ $reg_a_day }}
                        ],
                        borderWidth: 2,
                        borderColor: '#F675A8',
                    },
                    {
                        label: "Mankir Hari Libur",
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
                        text: 'Todate Kehadiran Regular per {{ $date }} BSKP'
                    },
                }
            }

        });
    </script>
</body>
