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
                                <h2 class="text-white text-capitalize ps-3">Laporan Kehadiran Detail - Shift</h2>

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
                                    <div class="text-center text-light bg-dark text-xxxl mb-2"
                                        style="font-size: 18px;padding-bottom: 10px;padding-top: 10px;margin-bottom: -100px;">
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
                                        </div>
                                        <div class="col-6">
                                            <table class="table table-bordered border-warning">
                                                <thead class="bg-warning text-center text-light">
                                                    <tr>
                                                        <th colspan="3">Informasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                                                        <td colspan="3" class="text-center">Dinas (D)</td>
                                                    </tr>
                                                    <tr></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr class="bg-dark text-light">
                                                        <th colspan="3">Jadwal Shift</th>
                                                    </tr>
                                                    <tr class="bg-info text-light">
                                                        <th>Tanggal</th>
                                                        <th>Shift</th>
                                                        <th>Jam</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body px-0 pb-2">
                                    <div class="text-center text-light bg-dark text-xxxl mb-2"
                                        style="font-size: 18px;padding-bottom: 10px;padding-top: 10px;margin-bottom: -100px;">
                                        Summary Kehadiran
                                    </div>
                                </div>


                                <div style="overflow-x:auto;">
                                    <table class="table table-bordered text-center border-dark" id="myTablex">
                                        <thead class="bg-primary text-light border-light">
                                            <tr>
                                                <th rowspan="2">Hari/Tanggal</th>
<<<<<<< HEAD
                                                <th colspan="2">Absen <br> Masuk</th>
                                                <th colspan="2">Absen <br> Keluar</th>
                                                <th rowspan="2"
                                                    style="max-width: 90px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    Total <br> Jam <br> Kerja</th>
=======
                                                <th rowspan="2">Lokasi <br> Absen</th>
                                                <th rowspan="2">Jam <br> Masuk</th>
                                                <th rowspan="2">Lokasi <br> Absen</th>
                                                <th rowspan="2">Jam <br> Keluar</th>
                                                <th rowspan="2" style="max-width: 90px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Total <br> Jam <br> Kerja</th>
>>>>>>> 0a7126e1fd2cc5e203d721306f6bda0a7f885c88
                                                <th rowspan="2">OT</th>
                                                <th rowspan="2">H</th>
                                                <th rowspan="4">L</th>
                                                <th rowspan="2">TA</th>
                                                <th rowspan="2">D</th>
                                                <th colspan="4">M</th>
                                                <th colspan="4">S</th>
                                                <th colspan="6">I</th>
                                                <th colspan="8">C</th>
                                                <th colspan="6" rowspan="2">Ket</th>
                                            </tr>
                                            <tr>
                                                <th>Lokasi</th>
                                                <th>Jam</th>
                                                <th>Lokasi</th>
                                                <th>Jam</th>
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
                                                $totalResult = 0;
                                                $rowCount = 0;
                                            @endphp

                                            @foreach ($emp1 as $item)
<<<<<<< HEAD
=======
                                            @php
                                                $rowColor = $rowCount % 2 == 0 ? 'background-color: #f0f0f0;' : 'background-color: #e0e0e0;';
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
                                                @else
                                                    <td>-</td>
                                                @endif

                                                {{-- Jam masuk --}}
                                                <td>
                                                    {{ Carbon\Carbon::parse($item->masuk)->format('H : i') }}
                                                </td>

                                                {{-- lokasi Absen --}}
                                                @if ($locEndWork == "FIO66206022260004")
                                                    <td>FAC</td>
                                                @elseif ($locEndWork == "FIO66208023070030")
                                                    <td>HO</td>
                                                @else
                                                    <td>-</td>
                                                @endif

                                                {{-- Jam Keluar --}}
                                                @if ($item->pulang == null)
                                                    <td></td>
                                                @else
                                                    <td>{{ Carbon\Carbon::parse($item->pulang)->format('H : i') }}</td>
                                                @endif

                                                {{-- Total Jam Kerja --}}
                                                <td>{{ number_format($item->tjk, 1) }}</td>

>>>>>>> 0a7126e1fd2cc5e203d721306f6bda0a7f885c88
                                                @php
                                                    $rowColor = $rowCount % 2 == 0 ? 'background-color: #f0f0f0;' : 'background-color: #e0e0e0;';
                                                @endphp
                                                <tr style="{{ $rowColor }}">
                                                    {{-- Tanggal --}}
                                                    <td>
                                                        {{ Carbon\Carbon::parse($item->date)->translatedFormat('D, d-M-y') }}
                                                    </td>

                                                    {{-- Lokasi Jam Masuk --}}
                                                    <td>
                                                        @if ($item->masuk_mesin == 'FIO66206022260004')
                                                            Factory
                                                        @else
                                                            Head Office
                                                        @endif
                                                    </td>

                                                    {{-- Jam masuk --}}
                                                    <td>
                                                        {{ Carbon\Carbon::parse($item->masuk)->format('H:i') }}
                                                    </td>

                                                    {{-- Lokasi Jam Pulang --}}
                                                    <td>
                                                        @if ($item->pulang != null)
                                                            @if ($item->pulang_mesin == 'FIO66206022260004')
                                                                Factory
                                                            @else
                                                                Head Office
                                                            @endif
                                                        @else
                                                        -
                                                        @endif
                                                    </td>

                                                    {{-- Jam Keluar --}}
                                                    @if ($item->pulang == null)
                                                        <td></td>
                                                    @else
                                                        <td>{{ Carbon\Carbon::parse($item->pulang)->format('H:i') }}
                                                        </td>
                                                    @endif

                                                    {{-- Total Jam Kerja --}}
                                                    <td>
                                                        {{ number_format($item->tjk - 1, 2) }}
                                                    </td>

                                                    @php
                                                        $totalSum = 0;
                                                    @endphp

                                                    {{-- OT --}}
                                                    @if ($item->dept == 'Factory')
                                                        @php
                                                            $tjk = number_format($item->tjk, 1) - number_format($item->shift, 1);
                                                            $totalResult += $tjk;
                                                        @endphp
                                                        <td>{{ $tjk }}</td>
                                                    @else
                                                        <td>{{ number_format($item->tjk - 9, 2) }}</td>
                                                    @endif

                                                    {{-- H --}}
                                                    @if ($item->desc == 'H')
                                                        <td>I</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                    {{-- L --}}
                                                    @if ($item->desc == 'L')
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

                                                    {{-- M --}}
                                                    @if ($item->desc == 'M')
                                                        <td colspan="2">I</td>
                                                    @else
                                                        <td colspan="2">0</td>
                                                    @endif

                                                    {{-- MX --}}
                                                    @if ($item->desc == 'MX')
                                                        <td colspan="2">I</td>
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
                                                    @if ($item->desc == 'CL')
                                                        <td colspan="2">I</td>
                                                    @else
                                                        <td colspan="2">0</td>
                                                    @endif

                                                    {{-- Keterangan --}}
                                                    <td>
                                                        {{ $item->info }}
                                                    </td>
                                                </tr>
                                                @php
                                                    $rowCount++;
                                                @endphp
                                            @endforeach
                                            <tr></tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-secondary text-light bordered-light">
                                                <td colspan="">Total Hari: {{ $emp1->count() }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
<<<<<<< HEAD

                                                <td colspan="">
                                                    {{ number_format($totalHours->result - $emp1->count(), 2) }} Jam</td>
=======
                                                <td></td>
                                                <td></td>
                                                <td colspan="">{{ number_format($totalHours->result-(1*$totalDaysWithData),2) }} Jam</td>
>>>>>>> 0a7126e1fd2cc5e203d721306f6bda0a7f885c88
                                                <td>{{ $totalResult }} Jam</td>
                                                <td>{{ $H }}</td>
                                                <td>{{ $L }}</td>
                                                <td>{{ $TA }}</td>
                                                <td>{{ $D }}</td>
                                                <td colspan="2">{{ $M }}</td>
                                                <td colspan="2">{{ $MX }}</td>
                                                <td colspan="2">{{ $S }}</td>
                                                <td colspan="2">{{ $SX }}</td>
                                                <td colspan="2">{{ $I }}</td>
                                                <td colspan="2">{{ $IP }}</td>
                                                <td colspan="2">{{ $IX }}</td>
                                                <td colspan="2">{{ $CT }}</td>
                                                <td colspan="2">{{ $CB }}</td>
                                                <td colspan="2">{{ $CH }}</td>
                                                <td colspan="2">{{ $CL }}</td>
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
            TableToExcel.convert(document.getElementById("myTablex"), {
                name: "{{ $firstDay }} - {{ $lastDay }} Summary Attendance ({{ $emp->nik }}-{{ $emp->name }}).xlsx",
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.column-toggle').change(function() {
                var column = $(this).data('column');
                var isChecked = $(this).prop('checked');

                $('#example th:nth-child(' + (column + 1) + '), #example td:nth-child(' + (column + 1) +
                    ')').toggle(isChecked);
            });
        });
    </script>
</body>
