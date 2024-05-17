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
</style>
<body class="g-sidenav-show bg-gray-200">
    @include('sweetalert::alert')
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h2 class="text-white text-capitalize ps-3">Laporan Kehadiran Detail - Harian</h2>
                            </div>
                        </div>
                        <div>
                            <div class="card-body">
                                <h1 class="mt-3">PT. Bridgestone Kalimantan Plantation</h1>
                                <button class="btn btn-success btn-sm" id="btn-d">Download Excel</button>

                                <div class="row">
                                    <form action="{{ route('print-attendance-filter') }}" method="POST">
                                        @csrf
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="nik" value="{{ $emp->nik }}">
                                                    <select class="form-select" aria-label="Default select example" name="month">
                                                        <option selected disabled>Filter Bulan</option>
                                                        <option value="1">Januari</option>
                                                        <option value="2">Februari</option>
                                                        <option value="3">Maret</option>
                                                        <option value="4">April</option>
                                                        <option value="5">Mei</option>
                                                        <option value="6">Juni</option>
                                                        <option value="7">Juli</option>
                                                        <option value="8">Agustus</option>
                                                        <option value="9">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">-</td>
                                                <td>
                                                    <select class="form-select" aria-label="Default select example" name="year">
                                                        <option selected disabled>Filter Tahun</option>
                                                        @foreach ($year as $y)
                                                            <option value="{{ $y->year }}">{{ $y->year }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm"
                                                        type="submit">Preview PDF</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>

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
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="nik" value="{{ $emp->nik }}">
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="from" id="">
                                                </td>
                                                <td class="text-center">-</td>
                                                <td>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="to" id="">
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
                                    <div class="text-center text-light bg-dark text-xxxl mb-2" style="font-size: 18px;padding-bottom: 10px;padding-top: 10px;margin-bottom: -100px;">
                                        @if ($firstDay == null && $lastDay == null)
                                            {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d M, Y') }}
                                        @else
                                            {{ $firstDay }} to {{ $lastDay }}
                                        @endif
                                    </div>
                                    <br>
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
                                            <div class="row">
                                                <div class="col-4">
                                                    <table class="table table-bordered border-secondary">
                                                        <thead class="bg-secondary text-light text-center">
                                                            <tr>
                                                                <th colspan="2">Total Hari ({{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('F') }})</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center fs-3 fw-bold">
                                                            <tr>
                                                                <td>{{ $totalDaysWithData }}</td>
                                                            </tr>
                                                            <tr></tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-2">
                                                    <table class="table table-bordered border-secondary">
                                                        <thead class="bg-secondary text-light text-center">
                                                            <tr>
                                                                <th colspan="2">Total Hari Kerja / Total Kehadiran</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center fs-3 fw-bold">
                                                            <tr>
                                                                <td>{{ $totalDaysWithoutMXData }} / {{ $emp1_total->h + $emp1_total->ta + $emp1_total->d + $emp1_total->l + $emp1_total->s + $emp1_total->i + $emp1_total->ip + $emp1_total->ct + $emp1_total->ch + $emp1_total->cb + $emp1_total->cl }}</td>
                                                            </tr>
                                                            <tr></tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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

                                <div class="card-body px-0 pb-2">
                                    <div class="text-center text-light bg-dark text-xxxl mb-2" style="font-size: 18px;padding-bottom: 10px;padding-top: 10px;margin-bottom: -100px;">
                                        Summary Kehadiran
                                    </div>
                                </div>

                                <div style="overflow-x:auto;">
                                    <table class="table table-bordered text-center border-dark" id="example">
                                        <thead class="bg-primary text-light border-light">
                                            <tr>
                                                <th rowspan="2">Hari/Tanggal</th>
                                                <th colspan="2">Absen Masuk</th>
                                                <th colspan="2">Absen Pulang</th>
                                                <th rowspan="2" style="max-width: 90px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Total <br> Jam <br> Kerja</th>
                                                <th rowspan="2">OT</th>
                                                <th rowspan="2">H</th>
                                                <th rowspan="2">TA</th>
                                                <th rowspan="2">D</th>
                                                <th colspan="4">L</th>
                                                <th colspan="4">M</th>
                                                <th colspan="4">S</th>
                                                <th colspan="6">I</th>
                                                <th colspan="8">C</th>
                                                <th colspan="6" rowspan="2">Ket</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">Lokasi <br> Absen</th>
                                                <th rowspan="2">Jam <br> Masuk</th>
                                                <th rowspan="2">Lokasi <br> Absen</th>
                                                <th rowspan="2">Jam <br> Keluar</th>
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

                                            @foreach ($emp1 as $item)
                                            @php
                                                $rowColor = $rowCount % 2 == 0 ? 'background-color: #f0f0f0;' : 'background-color: #D1D0D1;';
                                                $locStartWork = $item->start_work_info;
                                                $locEndWork = $item->end_work_info;
                                            @endphp
                                            <tr style="{{ $rowColor }}">
                                                {{-- Tanggal --}}
                                                <td>
                                                    {{ Carbon\Carbon::parse($item->date)->translatedFormat('D, d-M-y') }}
                                                </td>

                                                {{-- lokasi Absen --}}
                                                @if ($locStartWork == "FIO66206022260004")
                                                    <td>FAC</td>
                                                @elseif ($locStartWork == "FIO66208023070030")
                                                    <td>HO</td>
                                                @elseif ($locStartWork == "FIO66208023190896" || $locStartWork == "Fio66208023190896")
                                                    <td>WS</td>
                                                @elseif ($locStartWork == "FIO66208023190729")
                                                    <td>I/B</td>
                                                @elseif ($locStartWork == "FIO66208023190194")
                                                    <td>II/D</td>
                                                @else
                                                    <td>-</td>
                                                @endif

                                                {{-- Jam masuk --}}
                                                @if ($item->masuk == null)
                                                    <td>-</td>
                                                @else
                                                    <td>
                                                        {{ Carbon\Carbon::parse($item->masuk)->format('H:i') }}
                                                    </td>
                                                @endif

                                                {{-- lokasi Absen --}}
                                                @if ($locEndWork == "FIO66206022260004")
                                                    <td>FAC</td>
                                                @elseif ($locEndWork == "FIO66208023070030")
                                                    <td>HO</td>
                                                @elseif ($locEndWork == "FIO66208023190896" || $locStartWork == "Fio66208023190896")
                                                    <td>WS</td>
                                                @elseif ($locEndWork == "FIO66208023190729")
                                                    <td>I/B</td>
                                                @elseif ($locEndWork == "FIO66208023190194")
                                                    <td>II/D</td>
                                                @else
                                                    <td>-</td>
                                                @endif

                                                {{-- Jam Keluar --}}
                                                @if ($item->pulang == null)
                                                    <td>-</td>
                                                @else
                                                    <td>{{ Carbon\Carbon::parse($item->pulang)->format('H:i') }}</td>
                                                @endif

                                                {{-- Total Jam Kerja --}}
                                                @if ($item->total_hour == null && $item->total_minute == null)
                                                    <td>-</td>
                                                @elseif ($item->total_hour > 0 && $item->total_minute < 0)
                                                    <td>{{ $item->total_hour}}:0</td>
                                                @elseif ($item->total_hour < 0 && $item->total_minute > 0)
                                                    <td>0:{{ $item->total_minute }}</td>
                                                @else
                                                    <td>{{ $item->total_hour}}:{{ $item->total_minute }}</td>
                                                @endif

                                                @php
                                                    $totalSum = 0;
                                                @endphp

                                                {{-- OT --}}
                                                @if ($item->overtime_hour == null && $item->overtime_minute == null)
                                                    <td>-</td>
                                                @elseif ($item->overtime_hour <= 0 && $item->overtime_minute <= 0)
                                                    <td>-</td>
                                                @else
                                                    <td>{{ $item->overtime_hour ?? 0 }}:{{ $item->overtime_minute ?? 0 }}</td>
                                                @endif

                                                {{-- H --}}
                                                @if ($item->hadir == 1 && $item->desc != 'MX')
                                                    <td>I</td>
                                                @else
                                                    <td>0</td>
                                                @endif

                                                {{-- TA --}}
                                                @if ($item->desc == 'TA')
                                                    <td>I</td>
                                                @else
                                                    <td>0</td>
                                                @endif

                                                {{-- D --}}
                                                @if ($item->desc == 'D')
                                                    <td>I</td>
                                                @else
                                                    <td>0</td>
                                                @endif

                                                {{-- L --}}
                                                @if ($item->desc == 'L')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                @if ($item->desc != 'L')
                                                    <td colspan="2">0</td>
                                                @else
                                                    <td colspan="2">{{ $item->late_hour }}:{{ $item->late_minute }}</td>
                                                @endif

                                                {{-- M --}}
                                                @if ($item->desc == 'M')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- MX --}}
                                                @if ($item->desc == 'MX' && $item->masuk == null)
                                                    <td colspan="2">I</td>
                                                @elseif ($item->desc == 'MX' && $item->masuk != null)
                                                    <td colspan="2">0</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- S --}}
                                                @if ($item->desc == 'S')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- SX --}}
                                                @if ($item->desc == 'SX')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- I --}}
                                                @if ($item->desc == 'I')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- IP --}}
                                                @if ($item->desc == 'IP')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- IX --}}
                                                @if ($item->desc == 'IX')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif


                                                {{-- CT --}}
                                                @if ($item->desc == 'CT')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- CH --}}
                                                @if ($item->desc == 'CH')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- CB --}}
                                                @if ($item->desc == 'CB')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- CL --}}
                                                @if ($item->desc == 'CL' || $item->desc == 'CLL')
                                                    <td colspan="2">I</td>
                                                @else
                                                    <td colspan="2">0</td>
                                                @endif

                                                {{-- Keterangan --}}
                                                @if ($item->info == null)
                                                    <td class="text-left" colspan="1">-</td>
                                                @else
                                                    <td class="text-left" colspan="1">{{ $item->info }}</td>
                                                @endif

                                            </tr>
                                            @php
                                                $rowCount++;
                                                    $latemintoHour = $item->late_minute / 60;
                                                    $totalLateHourEndA = $item->late_hour += $latemintoHour;
                                            @endphp
                                            @endforeach
                                            <tr></tr>
                                        </tbody>
                                        @php
                                            $tjkmtoHour = $emp1_total->tjkm / 60;
                                            $tothtoHour = $emp1_total->totm / 60;
                                        @endphp
                                        <tfoot>
                                            <tr class="bg-secondary text-light bordered-light">
                                                <td colspan="">Total Hari: {{ $totalDaysWithData }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td colspan=""> {{ number_format($emp1_total->tjkx += $tjkmtoHour) }} Jam</td>
                                                <td>{{ number_format($emp1_total->toth += $tothtoHour, 1) }} Jam</td>
                                                <td>{{ $emp1_total->hadir }}</td>
                                                <td>{{ $emp1_total->ta }}</td>
                                                <td>{{ $emp1_total->d }}</td>
                                                <td colspan="2">{{ $emp1_total->l }}</td>
                                                <td colspan="2">{{ round($totalLateHourEnd, 1)}} Jam</td>
                                                <td colspan="2">{{ $emp1_total->m }}</td>
                                                <td colspan="2">{{ $emp1_total->mx }}</td>
                                                <td colspan="2">{{ $emp1_total->s }}</td>
                                                <td colspan="2">{{ $emp1_total->sx }}</td>
                                                <td colspan="2">{{ $emp1_total->i }}</td>
                                                <td colspan="2">{{ $emp1_total->ip }}</td>
                                                <td colspan="2">{{ $emp1_total->ix }}</td>
                                                <td colspan="2">{{ $emp1_total->ct }}</td>
                                                <td colspan="2">{{ $emp1_total->cb }}</td>
                                                <td colspan="2">{{ $emp1_total->ch }}</td>
                                                <td colspan="2">{{ $emp1_total->cl }}</td>
                                                {{-- <td>Total Kehadiran: {{ $emp1_total->h + $emp1_total->ta + $emp1_total->d + $emp1_total->l + $emp1_total->s + $emp1_total->i + $emp1_total->ip + $emp1_total->ct + $emp1_total->ch + $emp1_total->cb + $emp1_total->cl }}</td> --}}
                                                <td></td>
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
