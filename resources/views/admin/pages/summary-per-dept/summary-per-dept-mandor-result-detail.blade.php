@include('admin.includes.head')

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
                                <h6 class="text-white text-capitalize ps-3">Kehadiran Karyawan Per Dept</h6>
                            </div>
                        </div>
                        <div class="card mx-3 my-3">
                            <div class="card-header">
                                <h3><strong>Laporan Karyawan Tidak Masuk Kerja</strong></h3>
                            </div>
                            <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                @csrf
                                <div class="card-body">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right">
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Dept: {{ $dept }}</h4>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <p>Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    {{-- Tabel kategori bukan L --}}
                                    <table class="table table-bordered table-data table-striped">
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Status</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Kemandoran</th>
                                                <th>Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($detailKehadiran->isEmpty())
                                                <td colspan="8" class="text-center">Data tidak tersedia.</td>
                                            @else
                                                @php
                                                    $counter = 1;
                                                @endphp
                                                @foreach ($detailKehadiran as $th)
                                                    <tr>
                                                        <td class="text-center">{{ $counter++ }}</td>
                                                        <td>{{ $th->status }}</td>
                                                        <td>{{ $th->nik }}</td>
                                                        <td>{{ $th->name }}</td>
                                                        <td>{{ $mandorName }}</td>
                                                        <td class="text-center">{{ $th->desc }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                        <div class="card mx-3 my-3">
                            <div class="card-header">
                                <h3><strong>Laporan Karyawan Terlambat (L)</strong></h3>
                            </div>
                            <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                @csrf
                                <div class="card-body">
                                    {{-- Tabel kategori L --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Dept: {{ $dept }}</h4>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-data table-striped">
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Status</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Kemandoran</th>
                                                <th>Kategori</th>
                                                <th>Lokasi Absen</th>
                                                <th>Masuk Jam</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($detailKehadiranDescL->isEmpty())
                                                <td colspan="8" class="text-center">Data tidak tersedia.</td>
                                            @else
                                                @php
                                                    $counter = 1;
                                                @endphp
                                                @foreach ($detailKehadiranDescL as $thl)
                                                    <tr>
                                                        <td class="text-center">{{ $counter++ }}</td>

                                                        @if ($thl->status == 'Contract')
                                                            <td>FL</td>
                                                        @else
                                                            <td>{{ $thl->status }}</td>
                                                        @endif

                                                        <td>{{ $thl->nik }}</td>
                                                        <td>{{ $thl->name }}</td>
                                                        <td>{{ $mandorName }}</td>
                                                        <td class="text-center">{{ $thl->desc }}</td>

                                                        @if ($thl->start_work_info == "FIO66206022260004")
                                                            <td class="text-center">FAC</td>
                                                        @elseif ($thl->start_work_info == "FIO66208023070030")
                                                            <td class="text-center">HO</td>
                                                        @elseif ($thl->start_work_info == "FIO66208023190896" || $thl->start_work_info == "Fio66208023190896")
                                                            <td class="text-center">WS</td>
                                                        @elseif ($thl->start_work_info == "FIO66208023190729")
                                                            <td class="text-center">I/B</td>
                                                        @elseif ($thl->start_work_info == "FIO66208023190194")
                                                            <td class="text-center">II/D</td>
                                                        @else
                                                            <td class="text-center">-</td>
                                                        @endif

                                                        <td class="text-center">
                                                            {{ Carbon\Carbon::parse($thl->start_work)->translatedFormat('h:i') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
</body>
