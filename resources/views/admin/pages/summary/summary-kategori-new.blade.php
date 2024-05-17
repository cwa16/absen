@extends('admin.includes.head')

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
                                <h6 class="text-white text-capitalize ps-3">Laporan Karyawan Absen - Kategori</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right">
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Laporan Karyawan Absen - Kategori</h4>
                                                <h4>Dept: {{ $dept }}</h4>
                                            </div>
                                            <div class="col-md-6 text-md-end">
                                                <p>Periode Tgl: {{ \Carbon\Carbon::parse($startPeriod)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($endPeriod)->format('d/m/Y') }}</p>
                                                <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                            </div>
                                        </div>
                                        @if ($dept == 'I/A' || $dept == 'I/C' || $dept == 'II/E' || $dept == 'II/F')
                                            <table class="table table-bordered border-primary table-hover" id="example">
                                            <thead class="bg-primary text-light">
                                                <tr>
                                                    <th style="text-align: center;vertical-align: middle;padding: 0px;">No</th>
                                                    <th style="text-align: center;vertical-align: middle;">NIK</th>
                                                    <th style="text-align: center;vertical-align: middle;">Nama</th>
                                                    <th style="text-align: center;vertical-align: middle;padding: 0px;">Kemandoran</th>
                                                    <th style="text-align: center;vertical-align: middle;padding: 0px;">Status</th>
                                                    <th style="text-align: center;padding: 0px;">Kategori Tidak <br> Masuk Kerja</th>
                                                    <th style="text-align: center;padding: 0px;">Jumlah Tidak <br> Masuk Kerja</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $counter = 1; @endphp
                                                @foreach ($dataEmp as $emp)
                                                    @php
                                                        $attendanceCounts = [];
                                                        $dataKemandoran = DB::table('mandor_tappers')
                                                            ->join('users', 'mandor_tappers.user_id', '=', 'users.nik')
                                                            ->select(
                                                                'users.nik',
                                                                'users.name',
                                                            )
                                                            ->where('user_sub', $emp->nik)
                                                            ->first();
                                                        $dataAtts = App\Models\AbsenReg::where('user_id', $emp->nik)
                                                            ->whereIn('desc', $categories)
                                                            ->whereBetween('absen_regs.date', [$startPeriod, $endPeriod])
                                                            ->orderBy('absen_regs.user_id', 'asc')
                                                            ->get();
                                                        foreach ($dataAtts as $att) {
                                                            if (!isset($attendanceCounts[$att->desc])) {
                                                                $attendanceCounts[$att->desc] = 0;
                                                            }
                                                            $attendanceCounts[$att->desc]++;
                                                        }
                                                    @endphp
                                                    @if (count($attendanceCounts) > 0)
                                                        @foreach ($attendanceCounts as $desc => $count)
                                                            <tr>
                                                                <td style="text-align: center;vertical-align: middle;">{{ $counter++ }}</td>
                                                                <td style="vertical-align: middle;">{{ $emp->nik }}</td>
                                                                <td style="vertical-align: middle;">{{ $emp->name }}</td>
                                                                <td style="vertical-align: middle;">
                                                                    @if ($dataKemandoran)
                                                                        {{ $dataKemandoran->name }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">{{ $emp->status }}</td>
                                                                <td style="text-align: center;">{{ $desc }}</td>
                                                                <td style="text-align: center;">{{ $count }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                            <table class="table table-bordered border-primary table-hover" id="example">
                                            <thead class="bg-primary text-light">
                                                <tr>
                                                    <th style="text-align: center;vertical-align: middle;padding: 0px;">No</th>
                                                    <th style="text-align: center;vertical-align: middle;">NIK</th>
                                                    <th style="text-align: center;vertical-align: middle;">Nama</th>
                                                    <th style="text-align: center;vertical-align: middle;padding: 0px;">Kemandoran</th>
                                                    <th style="text-align: center;vertical-align: middle;padding: 0px;">Status</th>
                                                    <th style="text-align: center;padding: 0px;">Kategori Tidak <br> Masuk Kerja</th>
                                                    <th style="text-align: center;padding: 0px;">Jumlah Tidak <br> Masuk Kerja</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $counter = 1; @endphp
                                                @foreach ($dataEmp as $emp)
                                                    @php
                                                        $attendanceCounts = [];
                                                        $dataKemandoran = DB::table('mandor_tappers')
                                                            ->join('users', 'mandor_tappers.user_id', '=', 'users.nik')
                                                            ->select(
                                                                'users.nik',
                                                                'users.name',
                                                            )
                                                            ->where('user_sub', $emp->nik)
                                                            ->first();
                                                        $dataAtts = App\Models\TestingAbsen::where('user_id', $emp->nik)
                                                            ->whereIn('desc', $categories)
                                                            ->whereBetween('test_absen_regs.date', [$startPeriod, $endPeriod])
                                                            ->orderBy('test_absen_regs.user_id', 'asc')
                                                            ->get();
                                                        foreach ($dataAtts as $att) {
                                                            if (!isset($attendanceCounts[$att->desc])) {
                                                                $attendanceCounts[$att->desc] = 0;
                                                            }
                                                            $attendanceCounts[$att->desc]++;
                                                        }
                                                    @endphp
                                                    @if (count($attendanceCounts) > 0)
                                                        @foreach ($attendanceCounts as $desc => $count)
                                                            <tr>
                                                                <td style="text-align: center;vertical-align: middle;">{{ $counter++ }}</td>
                                                                <td style="vertical-align: middle;">{{ $emp->nik }}</td>
                                                                <td style="vertical-align: middle;">{{ $emp->name }}</td>
                                                                <td style="vertical-align: middle;">
                                                                    @if ($dataKemandoran)
                                                                        {{ $dataKemandoran->name }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">{{ $emp->status }}</td>
                                                                <td style="text-align: center;">{{ $desc }}</td>
                                                                <td style="text-align: center;">{{ $count }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
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
    <script src="{{ asset('js/tableToExcel.js') }}"></script>
    <script>
        $("#btn-d").click(function() {
            TableToExcel.convert(document.getElementById("example"), {
                name: "{{ $startPeriod }} - {{$endPeriod}} Laporan Karyawan Absen - Kategori ({{ $dept }}).xlsx",
            });
        });
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            sortTableByName();
        });

        function sortTableByName() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("example");
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[3];
                    y = rows[i + 1].getElementsByTagName("TD")[3];
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
            updateRowNumbers();
        }

        function updateRowNumbers() {
            var table = document.getElementById("example");
            var rows = table.rows;
            for (var i = 1; i < rows.length; i++) {
                rows[i].getElementsByTagName("TD")[0].innerHTML = i;
            }
        }
    </script>
</body>
