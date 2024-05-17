@include('admin.includes.head')

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
                                <h2 class="text-white text-capitalize ps-3">Laporan Kehadiran Detail - Regular</h2>

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


                                <div class="card-body px-0 pb-2 tableFixHeadw" style="overflow: auto">
                                    <table class="table table-bordered table-sm table-detail" id="myTablex">
                                        <thead>
                                            <tr>
                                                <th colspan="19" class="text-center">
                                                    @if ($firstDay == null && $lastDay == null)
                                                        {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d M, Y') }}
                                                    @else
                                                        {{ $firstDay }} to {{ $lastDay }}
                                                    @endif
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="text-center">Biodata</th>
                                                <th colspan="17" class="text-center">Informasi</th>
                                            </tr>
                                            <tr>
                                                <td class="info">NIK</td>
                                                <td class="info" colspan="6">{{ $emp->nik }}</td>
                                                <td colspan="8" rowspan="6"></td>
                                                <td class="info">H (Hadir)</td>
                                                <td class="info">M (Mangkir)</td>
                                                <td class="info">MX (Mangkir Hari Libur)</td>
                                                <td class="info" rowspan="4">C (Cuti)</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td colspan="6">{{ $emp->name }}</td>

                                                <td>I (Izin)</td>
                                                <td>IX (Izin Tidak Dibayar)</td>
                                                <td>OT (Lembur)</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td colspan="6">{{ $emp->status }}</td>

                                                <td>S (Sakit)</th>
                                                <td>SX (Sakit Tidak Dibayar)</th>
                                                <td>D (Dinas)</th>
                                            </tr>
                                            <tr>
                                                <td>Dept</td>
                                                <td colspan="6">{{ $emp->dept }}</td>

                                            </tr>
                                            <tr>
                                                <td>Jabatan</td>
                                                <td colspan="6">{{ $emp->jabatan }}</td>
                                            <tr>
                                            <tr>
                                                <th class="text-center" colspan="19">Summary Kehadiran</th>
                                            </tr>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Shift</th>
                                            <th>Jam Kerja</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Keluar</th>
                                            <th>Total Jam Kerja</th>
                                            <th>OT</th>
                                            <th>H</th>
                                            <th>M</th>
                                            <th>MX</th>
                                            <th>L</th>
                                            <th>I</th>
                                            <th>IX</th>
                                            <th>S</th>
                                            <th>SX</th>
                                            <th>C</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach ($emp1 as $item)
                                                <tr>
                                                    <td>{{ Carbon\Carbon::parse($item->date)->format('d-M-Y') }}
                                                    </td>

                                                    <td>{{ Carbon\Carbon::parse($item->date)->translatedformat('l') }}
                                                    </td>

                                                    <td>
                                                        @php
                                                            $toleranceMinutes = 30; // Toleransi 30 menit
                                                            $shiftStartTime = Carbon\Carbon::parse($item->shift_start_hour . ':00:00');
                                                            $absenStartTime = Carbon\Carbon::parse($item->absen_start_hour . ':00:00');
                                                            $earliestStartTime = $shiftStartTime->copy()->subMinutes($toleranceMinutes);

                                                            if ($absenStartTime >= $earliestStartTime && $absenStartTime <= $shiftStartTime) {
                                                                echo 'Sesuai';
                                                            } else {
                                                                echo '<span class="text-danger">Tidak Sesuai</span>';
                                                            }
                                                        @endphp
                                                    </td>

                                                    <td>{{ Carbon\Carbon::parse($emp->start_work)->format('H:i:s') }}
                                                        -
                                                        {{ Carbon\Carbon::parse($emp->end_work)->format('H:i:s') }}
                                                    </td>

                                                    <td>{{ Carbon\Carbon::parse($item->start_work)->format('H:i:s') }}
                                                    </td>

                                                    {{-- jam Keluar --}}
                                                    @if ($item->end_work_user == null)
                                                        <td></td>
                                                    @else
                                                        <td>{{ Carbon\Carbon::parse($item->end_work)->format('H:i:s') }}
                                                        </td>
                                                    @endif

                                                    {{-- Total Jam Kerja --}}
                                                    <td id="val">{{ number_format($item->result, 1) }}</td>

                                                    {{-- OT --}}
                                                    @if ($item->result > 8)
                                                        <td class="ot">
                                                            {{ number_format($item->result, 1) - number_format($item->userWork, 1) + 1 }}

                                                        </td>
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                    {{-- H --}}
                                                    @if ($item->desc == 'H')
                                                        <td>I</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                    {{-- M --}}
                                                    @if ($item->desc == 'M')
                                                        <td>I</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                    {{-- M --}}
                                                    @if ($item->desc == 'M')
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


                                                    {{-- I --}}
                                                    @if ($item->desc == 'I')
                                                        <td>I</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                    {{-- IX --}}
                                                    @if ($item->desc == 'IX')
                                                        <td>I</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                    {{-- S --}}
                                                    @if ($item->desc == 'S')
                                                        <td>I</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                    {{-- SX --}}
                                                    @if ($item->desc == 'SX')
                                                        <td>I</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                    {{-- C --}}
                                                    @if ($item->desc == 'C' ||
                                                        $item->desc == 'CB' ||
                                                        $item->desc == 'CT' ||
                                                        $item->desc == 'CH' ||
                                                        $item->desc == 'CS' ||
                                                        $item->desc == 'CLL')
                                                        <td>I</td>
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">Total Hari: {{ $emp->absen_reg->count() }}</td>
                                                <td>{{ number_format($totalHours) }} Jam</td>
                                                <td>{{ number_format($rr) }} Jam</td>
                                                <td>{{ $emp->absen_reg->where('desc', 'H')->count() }}</td>
                                                <td>{{ $emp->absen_reg->where('desc', 'M')->count() }}</td>
                                                <td>{{ $emp->absen_reg->where('desc', 'MX')->count() }}</td>
                                                <td>{{ $emp->absen_reg->where('desc', 'L')->count() }}</td>
                                                <td>{{ $emp->absen_reg->where('desc', 'I')->count() }}</td>
                                                <td>{{ $emp->absen_reg->where('desc', 'IX')->count() }}</td>
                                                <td>{{ $emp->absen_reg->where('desc', 'S')->count() }}</td>
                                                <td>{{ $emp->absen_reg->where('desc', 'SX')->count() }}</td>
                                                <td>{{ $emp->absen_reg->whereIn('desc', ['C', 'CB', 'CT', 'CH', 'CS', 'CLL'])->count() }}
                                                </td>
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
                name: "{{ $firstDay }} - {{$lastDay}} Summary Attendance ({{ $emp->nik }}-{{ $emp->name }}).xlsx",
            });
        });
    </script>
    <script>
        $(function() {
            $(".tableFixHeadw").freezeTable({
                'scrollBar': true,
                'scrollable': true,
                'columnNum': 2


            });
        });
    </script>

</body>
