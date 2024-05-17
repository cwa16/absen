@include('admin.includes.head')
<link rel="stylesheet" href="{{ 'https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' }}">
<style>
    .tableFixHead {
        overflow-y: auto;
        height: 500px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 8px 16px;
        border: 1px solid #ccc;
    }

    th {
        background: #eee;
    }
</style>

<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
        <div class="container-fluid py-4">
            @include('sweetalert::alert')
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h2 class="text-white text-capitalize ps-3">Laporan Kehadiran Per Departement</h2>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="" width="30%">
                                <h4 class="mt-3">PT. Bridgestone Kalimantan Plantation</h4>
                                <table>
                                    <tr>
                                        <td>
                                            <form action="{{ route('summary-per-dept-filter-reg-new') }}"
                                                method="POST">
                                                <div class="form-inline">
                                                    @csrf
                                                    <label for="">
                                                        @if ($date1 == null)
                                                            <h5>Bulan:
                                                                {{ Carbon\Carbon::parse($monthLabel)->translatedformat('F Y') }}
                                                            </h5>
                                                        @else
                                                            <h5>Tanggal:
                                                                {{ Carbon\Carbon::parse($date1)->translatedformat('d F Y') }}
                                                                -
                                                                {{ Carbon\Carbon::parse($date2)->translatedformat('d F Y') }}
                                                            </h5>
                                                        @endif

                                                    </label>
                                                    <div class="row g-3">
                                                        <div class="col">
                                                            <input type="date" class="form-control form-control-sm"
                                                                name="datex1" id="">
                                                        </div>
                                                        <div class="col">
                                                            <input type="date" class="form-control form-control-sm"
                                                                name="datex2" id="">
                                                        </div>
                                                        @if (Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'BSKP' || Auth::user()->dept == 'HR & Legal')
                                                            <div class="col">
                                                                <select name="dept" class="form-select"
                                                                    aria-label="multiple select example">
                                                                    <option value="null" selected>Dept. </option>
                                                                    @foreach ($dept as $item)
                                                                        <option value="{{ $item->dept }}">
                                                                            {{ $item->dept }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <select name="status" class="form-select"
                                                                    aria-label="multiple select example">
                                                                    <option value="null" selected>Status </option>
                                                                    @foreach ($status as $item)
                                                                        <option value="{{ $item->status }}">
                                                                            {{ $item->status }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        @endif
                                                        <div class="col">
                                                            <button class="btn btn-primary btn-sm"
                                                                type="submit">Filter</button>
                                                            <a href="#" id="btn-excel"
                                                                class="btn btn-success btn-sm">Export</a>
                                                            <a href="{{ route('summary-per-dept-filter-pdf') }}" class="btn btn-danger btn-sm">PDF</a>
                                                        </div>
                                                    </div>


                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-striped table-hover table-sm"
                                                style="font-size: 11px">
                                                <tr>
                                                    <th>H</th>
                                                    <th>Hadir</th>
                                                    <th>M</th>
                                                    <th>Mangkir</th>
                                                    <th>MX</th>
                                                    <th>Mangkir Hari Libur</th>
                                                    <th>CT</th>
                                                    <th>Cuti Tahunan</th>
                                                </tr>
                                                <tr>
                                                    <th>I</th>
                                                    <th>Izin</th>
                                                    <th>IP</th>
                                                    <th>Izin Pribadi</th>
                                                    <th>IX</th>
                                                    <th>Izin Tidak Dibayar</th>
                                                    <th>CH</th>
                                                    <th>Cuti Melahirkan</th>
                                                </tr>
                                                <tr>
                                                    <th>D</th>
                                                    <th>Dinas</th>
                                                    <th>TA</th>
                                                    <th>Tidak Absen</th>
                                                    <th>OT</th>
                                                    <th>Lembur</th>
                                                    <th>CB</th>
                                                    <th>Cuti Besar</th>
                                                </tr>
                                                <tr>
                                                    <th>S</th>
                                                    <th>Sakit</th>
                                                    <th>SX</th>
                                                    <th>Sakit Tidak Dibayar</th>
                                                    <th>L</th>
                                                    <th>Lambat</th>
                                                    <th>CL</th>
                                                    <th>Cuti Lain-lain</th>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>

                                <div class="card-body px-0 pb-2 shadow-sm">
                                    <div class="tableFixHeadw" style="overflow: scroll; height: 500px;">
                                        <table class="table table-striped table-hover table-sm" id="myTablex">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle" rowspan="2">Kode Emp
                                                    </th>
                                                    <th class="align-middle" rowspan="2">Nama</th>
                                                    <th class="align-middle" rowspan="2">Status
                                                    </th>
                                                    <th class="align-middle" rowspan="2">Jabatan</th>
                                                    {{-- <th class="align-middle" rowspan="2">Jam Masuk</th>
                                                    <th class="align-middle" rowspan="2">Jam Pulang</th> --}}
                                                    <th class="align-middle" rowspan="2">Total <br>Jam Kerja</th>
                                                    <th class="align-middle" rowspan="2">OT</th>
                                                    <th class="align-middle" rowspan="2">H</th>
                                                    <th class="align-middle text-center" colspan="2">L</th>
                                                    <th class="align-middle" rowspan="2">TA</th>
                                                    <th class="align-middle" rowspan="2">D</th>
                                                    <th class="align-middle text-center" colspan="2">M</th>
                                                    <th class="align-middle text-center" colspan="2">S</th>
                                                    <th class="align-middle text-center" colspan="3">I</th>
                                                    <th class="align-middle text-center" colspan="4">C</th>
                                                    <th class="align-middle text-center" rowspan="2">Total Hari / <br> Kehadiran</th>
                                                </tr>
                                                <tr>
                                                    <th class="align-middle">L</th>
                                                    <th class="align-middle">Hours</th>
                                                    <th class="align-middle">M</th>
                                                    <th class="align-middle">MX</th>
                                                    <th class="align-middle">S</th>
                                                    <th class="align-middle">SX</th>
                                                    <th class="align-middle">I</th>
                                                    <th class="align-middle">IP</th>
                                                    <th class="align-middle">IX</th>
                                                    <th class="align-middle">CT</th>
                                                    <th class="align-middle">CH</th>
                                                    <th class="align-middle">CB</th>
                                                    <th class="align-middle">CL</th>
                                                </tr>
                                                {{-- <tr>
                                                    @foreach ($day1 as $item)
                                                        <th>{{ $item }}</th>
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($day1 as $item)
                                                        <th class="thk">
                                                            {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-' . $item)->translatedformat('D') }}
                                                        </th>
                                                    @endforeach
                                                </tr> --}}
                                            </thead>
                                            <tbody style="font-size: 12px;">
                                                @foreach ($emp1 as $key => $item)
                                                    <tr>
                                                        <td><a
                                                                href="{{ route('view-summary-emp-testing', $item->nik) }}">{{ $item->nik }}</a>
                                                        </td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->status }}</td>
                                                        <td>{{ $item->jabatan }}</td>
                                                        @php
                                                            $day = $item->l + $item->h + $item->ta;
                                                            $tjk_sum = number_format($item->tjk, 2);
                                                            $shift_sum = number_format($item->shift - $day, 2);
                                                            $ot_sum = number_format($item->shift - $day, 2);
                                                            $jam = $item->tjkx;
                                                            $menit = $item->tjkm/60;
                                                            $detik = $item->tjks/3600;
                                                            $total_jam_kerja = $jam+$menit;
                                                            $latemintoHour = $item->latemin / 60;
                                                            $totalLateHourEnd = $item->latehour += $latemintoHour;
                                                            $tjkmtoHour = $item->tmin / 60;
                                                            $tothtoHour = $item->otmin / 60;
                                                            // dd($totalLateHourEnd);
                                                        @endphp
                                                        {{-- <td>{{ $item->tjk != null ? number_format($total_jam_kerja, 3) : 0 }}</td> --}}
                                                        @if ($item->thour == 0 || $item->tmin == 0)
                                                            <td>0</td>
                                                        @else
                                                            {{-- <td>{{ $item->thour }}, {{ $item->tmin }}</td> --}}
                                                            <td> {{ number_format($item->thour += $tjkmtoHour) }} Jam</td>
                                                        @endif
                                                        @php
                                                            $jam_ot = $item->othour;
                                                            $menit_ot = $item->otmin/60;
                                                            $res_otjam = $jam_ot+$menit_ot;
                                                        @endphp
                                                        {{-- Lembur dikurang Telat --}}
                                                        {{-- <td>{{ $tjk_sum > $shift_sum ? $ots : 0 }}</td> --}}
                                                        @php

                                                        @endphp
                                                        @if ($item->othour == 0 || $item->otmin == 0)
                                                            <td>0</td>
                                                        @else
                                                            {{-- <td>{{ $item->othour }}, {{ $item->otmin }}</td> --}}
                                                            <td>{{ number_format($item->othour += $tothtoHour) }} Jam</td>
                                                        @endif
                                                        <td>{{ $item->h }}</td>
                                                        <td>{{ $item->l }}</td>
                                                        {{-- <td>{{ $item->start_work }} - {{ $item->shifter }} | {{ $item->start_work > $start_inits[$key] ? $late[$key] : 0 }}</td> --}}
                                                        {{-- Jika jam masuk aktual lebih dari standar jam kerja masuk shift --}}
                                                        {{-- <td>{{ number_format($total_late, 1) }}</td> --}}
                                                        {{-- <td>{{ $item->latehour }}, {{ $item->latemin }}</td> --}}
                                                        @if ($item->l == 0)
                                                            <td>0 Jam</td>
                                                        @else
                                                            <td>{{ round($totalLateHourEnd, 1) }} Jam</td>
                                                        @endif
                                                        <td>{{ $item->ta }}</td>
                                                        <td>{{ $item->d }}</td>
                                                        <td>{{ $item->m }}</td>
                                                        <td>{{ $item->mx }}</td>
                                                        <td>{{ $item->s }}</td>
                                                        <td>{{ $item->sx }}</td>
                                                        <td>{{ $item->i }}</td>
                                                        <td>{{ $item->ip }}</td>
                                                        <td>{{ $item->ix }}</td>
                                                        <td>{{ $item->ct }}</td>
                                                        <td>{{ $item->ch }}</td>
                                                        <td>{{ $item->cb }}</td>
                                                        <td>{{ $item->cl }}</td>
                                                        @php
                                                            $totalAtt = $item->h + $item->s + $item->i + $item->d + $item->ip + $item->ct + $item->ch + $item->cb + $item->cl + $item->l + $item->ta;
                                                            // $totalAtt = $item->h + $item->l +  $item->ta +  $item->d +  $item->m +  $item->mx +  $item->s +  $item->sx +  $item->i +  $item->ip +  $item->ix +  $item->ct +  $item->ch +  $item->cb +  $item->cl;
                                                        @endphp
                                                        <td class="align-middle">{{ $totalDay }} Hari / {{ $totalAtt }} Hari</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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

    <script src="{{ 'js/tableToExcel.js' }}"></script>
    {{-- <script src="{{ 'js/jquery.floatThead.min.js' }}"></script> --}}
    <script src="{{ 'js/freeze-table.min.js' }}"></script>

    <script>
        $("#btn-excel").click(function() {
            TableToExcel.convert(document.getElementById("myTablex"), {
                name: "{{ $dateP }} Summary Attendance.xlsx",
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

    {{-- <script>
        $(function() {
            $('#myTablex').floatThead({
                scrollContainer: function($table) {
                    return $table.closest('.tableFixHead');
                }
            });

            $('#myTablex').stickyColumn({
                columns: 3
            });
        });
    </script> --}}

</body>
