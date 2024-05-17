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
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h2 class="text-white text-capitalize ps-3">Laporan Kehadiran - Monitoring</h2>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="" width="30%">
                                <h4 class="mt-3">PT. Bridgestone Kalimantan Plantation</h4>
                                <table>
                                    <tr>
                                        <td>
                                            <form action="{{ route('summary-per-dept-filter-reg') }}" method="POST">
                                                <div class="form-inline">
                                                    @csrf
                                                    <label for="">
                                                        <h5>Bulan:
                                                            {{ Carbon\Carbon::parse($monthLabel)->translatedformat('F Y') }}
                                                        </h5>
                                                    </label>
                                                    <div class="row g-3">
                                                        <div class="col">
                                                            <input type="date" class="form-control form-control-sm"
                                                                name="datex" id="">
                                                        </div>
                                                        @if (Auth::user()->dept == 'HR Legal' || Auth::user()->dept == 'BSKP' || Auth::user()->dept == 'HR & Legal')
                                                            <div class="col">
                                                                <select name="dept" class="form-select"
                                                                    aria-label="multiple select example">
                                                                    <option value="null" selected>Open this select
                                                                        menu</option>
                                                                    @foreach ($dept as $item)
                                                                        <option value="{{ $item->dept }}">
                                                                            {{ $item->dept }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        @endif
                                                        <div class="col">
                                                            <button class="btn btn-primary btn-sm"
                                                                type="submit">Filter</button>
                                                            <a href="#" id="btn-excel"
                                                                class="btn btn-success btn-sm">Export</a>
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
                                                    <th>I</th>
                                                    <th>Izin</th>
                                                    <th>IX</th>
                                                    <th>Izin Tidak Dibayar</th>
                                                </tr>
                                                <tr>
                                                    <th>L</th>
                                                    <th>Late (terlambat)</th>
                                                    <th>OT</th>
                                                    <th>Over Time (lembur)</th>
                                                    <th>S</th>
                                                    <th>Sakit</th>

                                                </tr>
                                                <tr>
                                                    <th>D</th>
                                                    <th>Dinas</th>
                                                    <th>E</th>
                                                    <th>Early (pulang cepat)</th>
                                                    <th>C</th>
                                                    <th>Cuti</th>
                                                </tr>
                                                <tr>
                                                    <th>M</th>
                                                    <th>Mangkir</th>
                                                    <th>MX</th>
                                                    <th>Mangkir Hari Libur</th>
                                                    <th>SX</th>
                                                    <th>Sakit Tidak Dibayar</th>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>

                                <div class="card-body px-0 pb-2 shadow-sm">
                                    <div class="tableFixHeadw" style="overflow: scroll; height: 500px;">
                                        <table class="table" id="myTablex">
                                            <thead>
                                                <tr>
                                                    <th rowspan="3" class="align-middle">Kode Emp
                                                    </th>
                                                    <th rowspan="3" class="align-middle">Nama</th>
                                                    <th rowspan="3" class="align-middle">Status
                                                    </th>
                                                    <th colspan="{{ $colSpan }}" class="text-center">
                                                        Tanggal
                                                    </th>
                                                    <th rowspan="3" class="align-middle">H</th>
                                                    <th rowspan="3" class="align-middle">L</th>
                                                    <th rowspan="3" class="align-middle">D</th>
                                                    <th rowspan="3" class="align-middle">E</th>
                                                    <th rowspan="3" class="align-middle">M</th>
                                                    <th rowspan="3" class="align-middle">MX</th>
                                                    <th rowspan="3" class="align-middle">I</th>
                                                    <th rowspan="3" class="align-middle">IX</th>
                                                    <th rowspan="3" class="align-middle">S</th>
                                                    <th rowspan="3" class="align-middle">SX</th>
                                                    <th rowspan="3" class="align-middle">C</th>
                                                    <th rowspan="3" class="align-middle">TA</th>
                                                </tr>
                                                <tr>
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
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px;">
                                                @foreach ($emp as $item => $users_list)
                                                    <tr>
                                                        <th colspan="{{ $colSpan }}">{{ $item }}</th>
                                                    </tr>
                                                    @foreach ($users_list->whereIn('status', ['Regular']) as $itemx)
                                                        <tr>
                                                            <td>{{ $itemx->nik }}</td>
                                                            <td>{{ $itemx->name }}</td>
                                                            <td>{{ $itemx->status }}</td>

                                                            @for ($i = 1; $i <= $colSpan; $i++)
                                                                <td>
                                                                    @foreach ($itemx->absen_reg as $absens)
                                                                        @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == $i)
                                                                            {{ $absens->desc }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            @endfor

                                                            <td>
                                                                {{ $itemx->absen_reg->where('desc', 'H')->count() }}
                                                            </td>

                                                            <td>{{ $itemx->absen_reg->where('desc', 'L')->count() }}
                                                            </td>

                                                            <td>
                                                                {{ $itemx->absen_reg->where('desc', 'D')->count() }}
                                                            </td>

                                                            <td>{{ $itemx->absen_reg->where('desc', 'E')->count() }}
                                                            </td>

                                                            <td>
                                                                {{ $itemx->absen_reg->where('desc', 'M')->count() }}
                                                            </td>

                                                            <td>
                                                                {{ $itemx->absen_reg->where('desc', 'MX')->count() }}
                                                            </td>

                                                            <td>
                                                                {{ $itemx->absen_reg->where('desc', 'I')->count() }}
                                                            </td>

                                                            <td>{{ $itemx->absen_reg->where('desc', 'IX')->count() }}
                                                            </td>

                                                            <td>
                                                                {{ $itemx->absen_reg->where('desc', 'S')->count() }}
                                                            </td>

                                                            <td>
                                                                {{ $itemx->absen_reg->where('desc', 'SX')->count() }}
                                                            </td>

                                                            <td>
                                                                {{ $itemx->absen_reg->whereIn('desc', ['CB', 'CT', 'CH', 'CS', 'CLL'])->count() }}
                                                            </td>

                                                            <td>
                                                                {{ $itemx->absen_reg->where('desc', 'TA')->count() }}
                                                            </td>


                                                        </tr>
                                                    @endforeach
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
