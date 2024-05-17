@include('admin.includes.head')
<style>
    .even-row {
        background-color: #f2f2f2;
    }

    .odd-row {
        background-color: #ffffff;
    }

    table {
        table-layout: auto;
    }
}
</style>
<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h2 class="text-white text-capitalize ps-3">Laporan Kehadiran Detail - Bulanan</h2>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h1 class="mt-3">PT. Bridgestone Kalimantan Plantation</h1>
                                <button class="btn btn-success btn-sm" id="btn-d">Download</button>

                                <div class="row">
                                    <form action="{{ route('view-summary-emp-filter-testing') }}" method="POST">
                                        @csrf
                                        <div class="col">
                                            <label for="">
                                                <h3>Periode:
                                                    @if ($firstDay == null && $lastDay == null)
                                                        {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d M, Y') }}
                                                    @else
                                                        {{ $firstDay }} to {{ $lastDay }}
                                                    @endif
                                                </h3>
                                            </label>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-body px-0 pb-2">
                                    <div class="row">
                                        <div class="col-6">
                                            <table class="table table-bordered border-success">
                                                <thead class="bg-success text-light text-center">
                                                    <tr>
                                                        <th colspan="2">Biodata</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>NIK</td>
                                                        <td>{{ $emp->nik }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>{{ $emp->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>{{ $emp->status }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dept</td>
                                                        <td>{{ $emp->dept }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jabatan</td>
                                                        <td>{{ $emp->jabatan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-success text-success">Jam Kerja</td>
                                                        <td class="bg-success text-success">07.00 - 15.00</td>
                                                    </tr>
                                                    <tr></tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-6">
                                            <table class="table table-bordered border-warning">
                                                <thead class="bg-warning text-center text-light">
                                                    <tr>
                                                        <th colspan="3">Informasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <tr>
                                                        <td>OT (Lembur)</td>
                                                        <td>H (Hadir)</td>
                                                        <td>L (Lambat)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TA (Tidak Absen)</td>
                                                        <td>M (Mangkir)</td>
                                                        <td>MX (Mangkir Hari Libur)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>I (Izin)</td>
                                                        <td>IP (Izin Pribadi)</td>
                                                        <td>IX (Izin Tidak Dibayar)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>S (Sakit)</td>
                                                        <td>SX (Sakit Tidak Dibayar)</td>
                                                        <td>CT (Cuti Tahunan)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>CH (Cuti Melahirkan)</td>
                                                        <td>CL (Cuti Lain-lain)</td>
                                                        <td>CB (Cuti Besar)</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-warning"></td>
                                                        <td>D (Dinas)</td>
                                                        <td class="bg-warning"></td>
                                                    </tr>
                                                    <tr></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div style="overflow-x:auto;">
                                    <table class="table table-bordered text-center border-dark" id="example">
                                        <thead class="bg-primary text-light border-light">
                                            <tr>
                                                <th rowspan="2">Bulan</th>
                                                <th rowspan="2">OT</th>
                                                <th rowspan="2">H</th>
                                                <th rowspan="2">TA</th>
                                                <th rowspan="2">D</th>
                                                <th colspan="4">L</th>
                                                <th colspan="4">Mangkir</th>
                                                <th colspan="4">Sakit</th>
                                                <th colspan="6">Izin</th>
                                                <th colspan="8">Cuti</th>
                                                <th colspan="6" rowspan="2">Ket</th>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Day</th>
                                                <th colspan="2">Hour</th>
                                                <th colspan="2">M</th>
                                                <th colspan="2">MX</th>
                                                <th colspan="2">S</th>
                                                <th colspan="2">SX</th>
                                                <th colspan="2">I</th>
                                                <th colspan="2">IP</th>
                                                <th colspan="2">IX</th>
                                                <th colspan="2">CT</th>
                                                <th colspan="2">CH</th>
                                                <th colspan="2">CB</th>
                                                <th colspan="2">CL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $rowCount = 0;
                                            @endphp

                                            @foreach ($totals as $monthName => $data)
                                            @php
                                                $rowColor = $rowCount % 2 == 0 ? 'background-color: #f0f0f0;' : 'background-color: #e0e0e0;';
                                            @endphp
                                            <tr style="{{ $rowColor }}">
                                                <td>{{ $monthName }}</td>
                                                @if ($data['totalOTMonth'])
                                                    <td>{{ number_format($data['totalOTMonth'], 2) }} Jam</td>
                                                @else
                                                    <td>0 Jam</td>
                                                @endif
                                                <td>{{ $data['H'] }}</td>
                                                <td>{{ $data['TA'] }}</td>
                                                <td>{{ $data['D'] }}</td>
                                                <td colspan="2">{{ $data['L'] }}</td>

                                                @if ($data['totalSelisihMenit'] > 0)
                                                    <td colspan="2">{{ number_format($data['totalSelisihMenit'], 2) }}</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                <td colspan="2">{{ $data['M'] }}</td>
                                                <td colspan="2">{{ $data['MX'] }}</td>
                                                <td colspan="2">{{ $data['S'] }}</td>
                                                <td colspan="2">{{ $data['SX'] }}</td>
                                                <td colspan="2">{{ $data['I'] }}</td>
                                                <td colspan="2">{{ $data['IP'] }}</td>
                                                <td colspan="2">{{ $data['IX'] }}</td>
                                                <td colspan="2">{{ $data['CT'] }}</td>
                                                <td colspan="2">{{ $data['CH'] }}</td>
                                                <td colspan="2">{{ $data['CB'] }}</td>
                                                <td colspan="2">{{ $data['CL'] }}</td>
                                                <td></td>
                                            </tr>

                                            @php
                                                $rowCount++;
                                            @endphp
                                            @endforeach
                                            <tr></tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Rata-rata</td>
                                                <td rowspan="2" class="align-middle">{{ number_format($data['totalOTYear'], 2) }} Jam</td>
                                                <td>{{ round($data['TotH'] / 12) }}</td>
                                                <td>{{ round($data['TotTA'] / 12) }}</td>
                                                <td>{{ round ($data['TotD'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotL'] / 12) }}</td>
                                                <td colspan="2" class="align-middle" rowspan="2">{{ number_format($data['totalSelisihMenitYear'], 2) }}</td>
                                                <td colspan="2">{{ round($data['TotM'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotMX'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotS'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotSX'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotI'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotIP'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotIX'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotCT'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotCH'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotCB'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['TotCL'] / 12) }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah</td>
                                                <td>{{ $data['TotH'] }}</td>
                                                <td>{{ $data['TotTA'] }}</td>
                                                <td>{{ $data['TotD'] }}</td>
                                                <td colspan="2">{{ $data['TotL'] }}</td>
                                                <td colspan="2">{{ $data['TotM'] }}</td>
                                                <td colspan="2">{{ $data['TotMX'] }}</td>
                                                <td colspan="2">{{ $data['TotS'] }}</td>
                                                <td colspan="2">{{ $data['TotSX'] }}</td>
                                                <td colspan="2">{{ $data['TotI'] }}</td>
                                                <td colspan="2">{{ $data['TotIP'] }}</td>
                                                <td colspan="2">{{ $data['TotIX'] }}</td>
                                                <td colspan="2">{{ $data['TotCT'] }}</td>
                                                <td colspan="2">{{ $data['TotCH'] }}</td>
                                                <td colspan="2">{{ $data['TotCB'] }}</td>
                                                <td colspan="2">{{ $data['TotCL'] }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
    <script src="{{ asset('js/tableToExcel.js') }}"></script>
    <script src="{{ asset('js/freeze-table.min.js') }}"></script>
    <script>
        $("#btn-d").click(function() {
            TableToExcel.convert(document.getElementById("example"), {
                name: "{{ $firstDay }} - {{$lastDay}} Summary Attendance ({{ $emp->nik }}-{{ $emp->name }}).xlsx",
            });
        });
    </script>
</body>
