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
                                <h6 class="text-white text-capitalize ps-3">Detail Employee</h6>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>NIK</th>
                                                        <th>Nama</th>
                                                        <th>Departement</th>
                                                        <th>Jabatan</th>
                                                        <th>Email</th>
                                                        <th>Lokasi Kerja</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $emp->nik }}</td>
                                                        <td>{{ $emp->name }}</td>
                                                        <td>{{ $emp->dept }}</td>
                                                        <td>{{ $emp->jabatan }}</td>
                                                        <td>{{ $emp->email }}</td>
                                                        <td>{{ $emp->loc_kerja }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="card">
                                                        <div class="card-body text-center">
                                                            <img src="{{ url('image/' . $emp->image_url) }}"
                                                                alt="" style="width: 272px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-hover">
                                                        <tr>
                                                            <th>Domisili</th>
                                                            <td>{{ $emp->domisili }}</td>
                                                            <th>No. KTP</th>
                                                            <td>{{ $emp->no_ktp }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Sex</th>
                                                            <td>{{ $emp->sex }}</td>
                                                            <th>No. Telpon</th>
                                                            <td>{{ $emp->no_telpon }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <td>{{ $emp->status }}</td>
                                                            <th>KIS</th>
                                                            <td>{{ $emp->kis }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Grade</th>
                                                            <td>{{ $emp->grade }}</td>
                                                            <th>KPJ</th>
                                                            <td>{{ $emp->kpj }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>TTL</th>
                                                            <td>{{ $emp->ttl }}</td>
                                                            <th>No. Sepatu Safety</th>
                                                            <td>{{ $emp->no_sepatu_safety }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Mulai Kerja</th>
                                                            <td>{{ $emp->start }}</td>
                                                            <th>Aktual Cuti</th>
                                                            <td>{{ $emp->aktual_cuti }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Pendidikan</th>
                                                            <td>{{ $emp->pendidikan }}</td>
                                                            <th>Status Pernikahan</th>
                                                            <td>{{ $emp->status_pernikahan }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Ukuran Baju</th>
                                                            <td>{{ $emp->no_baju }}</td>
                                                            <th>Gol. Darah</th>
                                                            <td>{{ $emp->gol_darah }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Agama</th>
                                                            <td>{{ $emp->agama }}</td>
                                                            <th>Istri /Suami</th>
                                                            <td>{{ $emp->istri_suami }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Suku</th>
                                                            <td>{{ $emp->suku }}</td>
                                                            <th>Anak</th>
                                                            <td>1. {{ $emp->anak_1 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Bank Name</th>
                                                            <td colspan="2">{{ $emp->bank }}</td>
                                                            <td>2. {{ $emp->anak_2 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Bank Account</th>
                                                            <td colspan="2">{{ $emp->no_bank }}</td>
                                                            <td>3. {{ $emp->anak_3 }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="card mt-3">
                                                <div class="body">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2" class="text-center align-middle">
                                                                    Lokasi Absen</th>
                                                                <th rowspan="2" class="text-center align-middle">
                                                                    Sistem Absen</th>
                                                                <th rowspan="2" class="text-center align-middle">Jam
                                                                    Datang Kerja</th>
                                                                <th rowspan="2" class="text-center align-middle">Jam
                                                                    Pulang Kerja</th>
                                                                <th colspan="2" class="text-center">Kordinat</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-center">Latitude</th>
                                                                <th class="text-center">Longitude</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center">{{ $emp->loc }}</td>
                                                                <td class="text-center">{{ $emp->sistem_absensi }}</td>
                                                                <td class="text-center">{{ $emp->start_work_user }}
                                                                </td>
                                                                <td class="text-center">{{ $emp->end_work_user }}</td>
                                                                <td class="text-center">{{ $emp->latitude }}</td>
                                                                <td class="text-center">{{ $emp->longitude }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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

</body>
