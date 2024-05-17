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
                                    <form action="{{ route('view-summary-emp-filter-month') }}" method="POST">
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

                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="nik" value="{{ $emp->nik }}">
                                                    <select class="form-select" aria-label="Default select example" name="year">
                                                        <option selected disabled>Filter Tahun</option>
                                                        @foreach ($year as $y)
                                                            <option value="{{ $y->year }}">{{ $y->year }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm"
                                                        type="submit">Filter</button>
                                                </td>
                                            </tr>
                                        </table>
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
                                                        <td></td>
                                                        <td>D (Dinas)</td>
                                                        <td></td>
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
                                                <td>{{ number_format($data['totalOTMonthHourEnd']) }}</td>
                                                <td>{{ $data['HMonth'] }}</td>
                                                <td>{{ $data['TAMonth'] }}</td>
                                                <td>{{ $data['DMonth'] }}</td>
                                                <td colspan="2">{{ $data['LMonth'] }}</td>
                                                <td colspan="2">{{ number_format($data['totalLateMonthHourEnd']) }} Jam</td>
                                                <td colspan="2">{{ $data['MMonth'] }}</td>
                                                <td colspan="2">{{ $data['MXMonth'] }}</td>
                                                <td colspan="2">{{ $data['SMonth'] }}</td>
                                                <td colspan="2">{{ $data['SXMonth'] }}</td>
                                                <td colspan="2">{{ $data['IMonth'] }}</td>
                                                <td colspan="2">{{ $data['IPMonth'] }}</td>
                                                <td colspan="2">{{ $data['IXMonth'] }}</td>
                                                <td colspan="2">{{ $data['CTMonth'] }}</td>
                                                <td colspan="2">{{ $data['CHMonth'] }}</td>
                                                <td colspan="2">{{ $data['CBMonth'] }}</td>
                                                <td colspan="2">{{ $data['CLMonth'] }}</td>
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
                                                <td rowspan="2" class="align-middle">{{ number_format($data['totalOTYearHourEnd']) }} Jam</td>
                                                <td>{{ round($data['HYear'] / 12) }}</td>
                                                <td>{{ round($data['TAYear'] / 12) }}</td>
                                                <td>{{ round ($data['DYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['LYear'] / 12) }}</td>
                                                <td colspan="2" class="align-middle" rowspan="2">{{ number_format($data['totalLateYearHourEnd']) }} Jam</td>
                                                <td colspan="2">{{ round($data['MYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['MXYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['SYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['SXYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['IYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['IPYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['IXYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['CTYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['CHYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['CBYear'] / 12) }}</td>
                                                <td colspan="2">{{ round($data['CLYear'] / 12) }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah</td>
                                                <td>{{ $data['HYear'] }}</td>
                                                <td>{{ $data['TAYear'] }}</td>
                                                <td>{{ $data['DYear'] }}</td>
                                                <td colspan="2">{{ $data['LYear'] }}</td>
                                                <td colspan="2">{{ $data['MYear'] }}</td>
                                                <td colspan="2">{{ $data['MXYear'] }}</td>
                                                <td colspan="2">{{ $data['SYear'] }}</td>
                                                <td colspan="2">{{ $data['SXYear'] }}</td>
                                                <td colspan="2">{{ $data['IYear'] }}</td>
                                                <td colspan="2">{{ $data['IPYear'] }}</td>
                                                <td colspan="2">{{ $data['IXYear'] }}</td>
                                                <td colspan="2">{{ $data['CTYear'] }}</td>
                                                <td colspan="2">{{ $data['CHYear'] }}</td>
                                                <td colspan="2">{{ $data['CBYear'] }}</td>
                                                <td colspan="2">{{ $data['CLYear'] }}</td>
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
