@include('admin.includes.head')

<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Hadir (H)</p>
                                <h4 class="mb-0">{{ ($H != null) ? $H->total : 0}} ({{ ($H != null) ? number_format(($H->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($H_todate != null) ? number_format(($H_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Mangkir <strong>(M)</strong></p>
                                <h4 class="mb-0">{{ ($M != null) ? $M->total : 0}} ({{ ($M != null) ? number_format(($M->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($M_todate != null) ? number_format(($M_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Mangkir (Hari Libur) <strong>(MX)</strong></p>
                                <h4 class="mb-0">{{ ($MX != null) ? $MX->total : 0}} ({{ ($MX != null) ? number_format(($MX->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($MX_todate != null) ? number_format(($MX_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Lambat <strong>(L)</strong></p>
                                <h4 class="mb-0">{{ ($L != null) ? $L->total : 0}} ({{ ($L != null) ? number_format(($L->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($L_todate != null) ? number_format(($L_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Dinas <strong>(D)</strong></p>
                                <h4 class="mb-0">{{ ($D != null) ? $D->total : 0}} ({{ ($D != null) ? number_format(($D->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($D_todate != null) ? number_format(($D_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Early (Pulang Cepat) <strong>(E)</strong></p>
                                <h4 class="mb-0">{{ ($E != null) ? $E->total : 0}} ({{ ($E != null) ? number_format(($E->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($E_todate != null) ? number_format(($E_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mb-xl-0 mt-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Izin <strong>(I)</strong></p>
                                <h4 class="mb-0">{{ ($I != null) ? $I->total : 0}} ({{ ($I != null) ? number_format(($I->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($I_todate != null) ? number_format(($I_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mb-xl-0 mt-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Sakit <strong>(S)</strong></p>
                                <h4 class="mb-0">{{ ($S != null) ? $S->total : 0}} ({{ ($S != null) ? number_format(($S->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($S_todate != null) ? number_format(($S_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mt-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Cuti <strong>(C)</strong></p>
                                <h4 class="mb-0">{{ ($C != null) ? $C->total : 0}} ({{ ($C != null) ? number_format(($C->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($C_todate != null) ? number_format(($C_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mt-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Izin Tidak Dibayar <strong>(IX)</strong></p>
                                <h4 class="mb-0">{{ ($IX != null) ? $IX->total : 0}} ({{ ($IX != null) ? number_format(($IX->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($IX_todate != null) ? number_format(($IX_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mt-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Sakit Tidak Dibayar <strong>(SX)</strong></p>
                                <h4 class="mb-0">{{ ($SX != null) ? $SX->total : 0}} ({{ ($SX != null) ? number_format(($SX->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($SX_todate != null) ? number_format(($SX_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 mt-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Izin Pribadi <strong>(IP)</strong></p>
                                <h4 class="mb-0">{{ ($IP != null) ? $IP->total : 0}} ({{ ($IP != null) ? number_format(($IP->total/$totalReg)*100) : 0 }}%)</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span>
                                Todate <strong style="float: right">{{ ($IP_todate != null) ? number_format(($IP_todate->total/$totalRegTodate)*100) : 0 }}%</strong>
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
                                    <canvas id="chart-ket-dept-todate" class="chart-canvas" height="120"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Todate Kehadiran Harian BSKP</h6>
                            <p class="text-sm "> (<span class="font-weight-bolder">total Todate Kehadiran Regular BSKP
                            </p>
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
                                                        <option value="I/B">B</option>
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
                                                <th>IP</th>
                                                <th>IX</th>
                                                <th>S</th>
                                                <th>SX</th>
                                                <th>C</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm"> last updated at</p>
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
    var ctx = document.getElementById("chart-ket-dept-todate").getContext('2d');
    var myChart = new Chart(ctx, {

        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [
                {
                    label: 'Mangkir (M)',
                    data: {{ json_encode($Mget) }},
                    borderWidth: 2,
                    borderColor: '#1C315E',
                    backgroundColor: '#1C315E',
                    tension: 0.3
                },
                {
                    label: 'Mangkir (MX)',
                    data: {{ json_encode($MXget) }},
                    borderWidth: 2,
                    borderColor: '#227C70',
                    backgroundColor: '#227C70',
                    tension: 0.3
                },
                {
                    label: 'Libur (L)',
                    data: {{ json_encode($Lget) }},
                    borderWidth: 2,
                    borderColor: '#88A47C',
                    backgroundColor: '#88A47C',
                    tension: 0.3
                },
                {
                    label: 'Dinas (D)',
                    data: {{ json_encode($Dget) }},
                    borderWidth: 2,
                    borderColor: '#4B56D2',
                    backgroundColor: '#4B56D2',
                    tension: 0.3
                },
                {
                    label: 'Early (Pulang Cepat) (E)',
                    data: {{ json_encode($Eget) }},
                    borderWidth: 2,
                    borderColor: '#82C3EC',
                    backgroundColor: '#82C3EC',
                    tension: 0.3
                },
                {
                    label: 'Izin (I)',
                    data: {{ json_encode($Iget) }},
                    borderWidth: 2,
                    borderColor: '#00FFF6',
                    backgroundColor: '#00FFF6',
                    tension: 0.3
                },
                {
                    label: 'Sakit (S)',
                    data: {{ json_encode($Sget) }},
                    borderWidth: 2,
                    borderColor: '#00E7FF',
                    backgroundColor: '#00E7FF',
                    tension: 0.3
                },
                {
                    label: 'Cuti (C)',
                    data: {{ json_encode($Cget) }},
                    borderWidth: 2,
                    borderColor: '#009EFF',
                    backgroundColor: '#009EFF',
                    tension: 0.3
                },
                {
                    label: 'Izin Tidak Dibayar (IX)',
                    data: {{ json_encode($IXget) }},
                    borderWidth: 2,
                    borderColor: '#C47AFF',
                    backgroundColor: '#C47AFF',
                    tension: 0.3
                },
                {
                    label: 'Sakit Tidak Dibayar (SX)',
                    data: {{ json_encode($SXget) }},
                    borderWidth: 2,
                    borderColor: '#06283D',
                    backgroundColor: '#06283D',
                    tension: 0.3
                },
                {
                    label: 'Izin Pribadi (IP)',
                    data: {{ json_encode($IPget) }},
                    borderWidth: 2,
                    borderColor: '#FF33F3',
                    backgroundColor: '#FF33F3',
                    tension: 0.3
                },
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
                text: 'Kehadiran per '
            },
            layout: {
                padding: 30
            }
        }

    });
</script>

</body>
