@include('admin.includes.head')

<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('sweetalert::alert')
        @include('admin.layouts.navbar')
        <div class="container-fluid py-4">

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Edit Employee</h6>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('update-emp') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <table class="table table-striped table-responsive table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Aktif</th>
                                                            <th>Kode Karyawan</th>
                                                            <th>Nama</th>
                                                            <th>Departement</th>
                                                            <th>Jabatan</th>
                                                            <th>Email</th>
                                                            <th>Lokasi Kerja</th>
                                                            <th>Absent Code</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <input type="hidden" name="id"
                                                                value="{{ $emp->id }}">
                                                            <td>
                                                                <select name="active" id=""
                                                                    class="form-control form-control-sm">
                                                                    <option value="{{ $emp->active }}" selected>
                                                                        {{ $emp->active }}</option>
                                                                    <option value="yes">Yes</option>
                                                                    <option value="no">No</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="nik_emp"
                                                                    value="{{ $emp->nik }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="name"
                                                                    value="{{ $emp->name }}"></td>
                                                            <td>
                                                                <select name="dept" id=""
                                                                    class="form-control form-control-sm">
                                                                    <option value="{{ $emp->dept }}" selected>
                                                                        {{ $emp->dept }}</option>
                                                                    @foreach ($dept as $item)
                                                                        <option value="{{ $item->dept }}">
                                                                            {{ $item->dept }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="jabatan" id=""
                                                                    class="form-control form-control-sm">
                                                                    <option value="{{ $emp->jabatan }}" selected>
                                                                        {{ $emp->jabatan }}</option>
                                                                    @foreach ($position as $item)
                                                                        <option value="{{ $item->position }}">
                                                                            {{ $item->position }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="email"
                                                                    value="{{ $emp->email }}"></td>
                                                            <td>
                                                                <select name="loc_kerja" id=""
                                                                    class="form-control form-control-sm">
                                                                    <option value="{{ $emp->loc_kerja }}" selected>
                                                                        {{ $emp->loc_kerja }}</option>
                                                                    @foreach ($location as $item)
                                                                        <option value="{{ $item->location }}">
                                                                            {{ $item->location }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $emp->absent_code }}" disabled>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-4">
                                                <div class="card">
                                                    <div class="card-body">
                                                        @if ($emp->image_url == null)
                                                            <h2 class="text-center">No Photo</h2>
                                                            <div class="form-group">
                                                                <label for="exampleFormControlFile1">Masukkan gambar
                                                                    disini</label>
                                                                <input type="file" class="form-control-file"
                                                                    id="exampleFormControlFile1" name="file">
                                                            </div>
                                                        @else
                                                            <div class="card">
                                                                <div class="card-body text-center">
                                                                    <img src="{{ url('image/' . $emp->image_url) }}"
                                                                        alt="" style="width: 272px;">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleFormControlFile1">Masukkan gambar
                                                                    disini</label>
                                                                <input type="file" class="form-control-file"
                                                                    id="exampleFormControlFile1" name="file">
                                                                <a href="{{ route('delete-photo', $emp->nik) }}"
                                                                    class="btn btn-danger btn-sm mt-2">Delete</a>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-hover">
                                                            <tr>
                                                                <th>Domisili</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="domisili" value="{{ $emp->domisili }}">
                                                                </td>
                                                                <th>No. KTP</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="no_ktp" value="{{ $emp->no_ktp }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Sex</th>
                                                                <td>
                                                                    <select name="sex" id="" class="form-control form-control-sm">
                                                                        <option value="{{ $emp->sex }}" selected>{{ ($emp->sex = 'M') ? 'Pria' : 'Wanita' }}</option>
                                                                        <option value="M">Pria</option>
                                                                        <option value="F">Wanita</option>
                                                                    </select>
                                                                </td>
                                                                <th>No. Telpon</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="no_telpon"
                                                                        value="{{ $emp->no_telpon }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status</th>
                                                                <td><select class="form-control form-control-sm"
                                                                        name="status" required>
                                                                        <option value="{{ $emp->status }}" selected>
                                                                            {{ $emp->status }}</option>
                                                                        <option value="Staff">Staff</option>
                                                                        <option value="Monthly">Monthly</option>
                                                                        <option value="Regular">Regular</option>
                                                                        <option value="Contract BSKP">Contract BSKP
                                                                        </option>
                                                                        <option value="Contract FL">Contract FL
                                                                        </option>
                                                                    </select></td>
                                                                <th>KIS</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="kis" value="{{ $emp->kis }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Grade</th>
                                                                <td>
                                                                    <select name="grade" id="" class="form-control form-control-sm">
                                                                        <option value="{{ $emp->grade }}">{{ ($emp->grade) ? $emp->grade : '-- pilih --' }}</option>
                                                                        <option value="">Non Grade</option>
                                                                        @foreach ($grade as $item)
                                                                            <option value="{{ $item->grade }}">{{ $item->grade }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <th>KPJ</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="kpj" value="{{ $emp->kpj }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>TTL</th>
                                                                <td><input type="date"
                                                                        class="form-control form-control-sm"
                                                                        name="ttl" value="{{ $emp->ttl }}">
                                                                </td>
                                                                <th>No. Sepatu Safety</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="no_sepatu_safety"
                                                                        value="{{ $emp->no_sepatu_safety }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Mulai Kerja</th>
                                                                <td><input type="date"
                                                                        class="form-control form-control-sm"
                                                                        name="start_w" value="{{ $emp->start }}">
                                                                </td>
                                                                <th>Kemandoran</th>
                                                                <td>
                                                                    <select name="kemandoran" id=""
                                                                        class="form-control forn-control-sn">
                                                                        <option value="{{ $emp->kemandoran }}"
                                                                            selected>{{ $emp->kemandoran }}</option>
                                                                        <option value="">Tidak Ada</option>
                                                                        @foreach ($kemandoran as $item)
                                                                            <option value="{{ $item->nik }}">
                                                                                {{ $item->nik }} |
                                                                                {{ $item->name }} |
                                                                                {{ $item->dept }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pendidikan</th>
                                                                <td>
                                                                    <select name="pendidikan" id=""
                                                                        class="form-control form-control-sm">
                                                                        <option value="{{ $emp->pendidikan }}"
                                                                            selected>{{ $emp->pendidikan }}</option>
                                                                        @foreach ($education as $item)
                                                                            <option value="{{ $item->education }}">
                                                                                {{ $item->education }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <th>Status Pernikahan</th>
                                                                <td><select class="form-control form-control-sm"
                                                                        name="status_pernikahan">
                                                                        <option value="{{ $emp->status_pernikahan }}"
                                                                            selected>{{ $emp->status_pernikahan }}
                                                                        </option>
                                                                        <option value="S0">S0 (Belum Menikah)
                                                                        </option>
                                                                        <option value="K0">K0 (Menikah Belum Punya
                                                                            Anak)</option>
                                                                        <option value="K1">K1 (Menikah Anak 1)
                                                                        </option>
                                                                        <option value="K2">K2 (Menikah Anak 2)
                                                                        </option>
                                                                        <option value="K3">K3 (Menikah Anak 3)
                                                                        </option>
                                                                    </select></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Agama</th>
                                                                <td><select class="form-control form-control-sm"
                                                                        name="agama" required>
                                                                        <option value="{{ $emp->agama }}" selected>
                                                                            {{ $emp->agama }}</option>
                                                                        <option value="Islam">Islam</option>
                                                                        <option value="Kristen Katolik">Kristen Katolik
                                                                        </option>
                                                                        <option value="Kristen Protestan">Kristen
                                                                            Protestan
                                                                        </option>
                                                                        <option value="Buddha">Buddha</option>
                                                                        <option value="Hindu">Hindu</option>
                                                                    </select></td>
                                                                <th>Istri /Suami</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="istri_suami"
                                                                        value="{{ $emp->istri_suami }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Suku</th>
                                                                <td>
                                                                    <select name="suku" id=""
                                                                        class="form-control form-control-sm">
                                                                        <option value="{{ $emp->suku }}" selected>
                                                                            {{ $emp->suku }}</option>
                                                                        <option value="Banjar">Banjar</option>
                                                                        <option value="Jawa">Jawa</option>
                                                                        <option value="Dayak">Dayak</option>
                                                                        <option value="Flores">Flores</option>
                                                                        <option value="Bugis">Bugis</option>
                                                                        <option value="Lombok">Lombok</option>
                                                                        <option value="Madura">Madura</option>
                                                                        <option value="Sunda">Sunda</option>
                                                                        <option value="Timur-Timur">Timur-Timur
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <th>Gol. Darah</th>
                                                                <td>
                                                                    <select name="gol_darah" id=""
                                                                        class="form-control form-control-sm">
                                                                        <option value="">
                                                                            {{ $emp->gol_darah == null ? 'pilih' : $emp->gol_darah }}
                                                                        </option>
                                                                        <option value="o">O</option>
                                                                        <option value="a">A</option>
                                                                        <option value="b">B</option>
                                                                        <option value="ab">AB</option>
                                                                    </select>

                                                            </tr>
                                                            <tr>
                                                                <th>No. Baju</th>
                                                                <td>
                                                                    <select name="no_baju" id=""
                                                                        class="form-control form-control-sm">
                                                                        <option value="">
                                                                            {{ $emp->no_baju == null ? 'pilih' : $emp->no_baju }}
                                                                        </option>
                                                                        <option value="s">S</option>
                                                                        <option value="m">M</option>
                                                                        <option value="l">L</option>
                                                                        <option value="xl">XL</option>
                                                                        <option value="xxl">XXL</option>
                                                                        <option value="xxxl">XXXL</option>
                                                                    </select>
                                                                </td>
                                                                </td>
                                                                <th>Anak</th>
                                                                <td>1. <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="anak_1" value="{{ $emp->anak_1 }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Bank Name</th>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="bank" value="{{ $emp->bank }}">
                                                                </td>
                                                                <td>2. <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="anak_2" value="{{ $emp->anak_2 }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Account Number</th>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="no_bank" value="{{ $emp->no_bank }}">
                                                                </td>
                                                                <td>3. <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="anak_3" value="{{ $emp->anak_3 }}">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <br>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal" tabindex="-1"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalLabel">Apakah ini mutasi?
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <button class="btn btn-primary"
                                                                                            type="button"
                                                                                            id="yesBtn">Yes</button>
                                                                                        <button
                                                                                            class="btn btn-secondary"
                                                                                            type="submit"
                                                                                            name="action"
                                                                                            value="update">No</button>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row" id="date_mutation"
                                                                                    style="display:none;">
                                                                                    <label for="date_mutation">Tanggal
                                                                                        Mutasi</label>
                                                                                    <input type="date"
                                                                                        class="form-control"
                                                                                        name="date_mutation">
                                                                                </div>
                                                                                <div class="row">
                                                                                    <button
                                                                                        class="btn btn-primary mt-2"
                                                                                        type="submit"
                                                                                        id="update_mutation"
                                                                                        name="action"
                                                                                        value="mutation"
                                                                                        style="display: none;">Update</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <!-- Additional buttons if needed -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary text-right" name="action"
                                                            type="button" value=""
                                                            id="showModalBtn">UPDATE</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="card mt-3">
                                                    <div class="body">
                                                        <table class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2"
                                                                        class="text-center align-middle">Sistem Absen
                                                                    </th>
                                                                    <th rowspan="2"
                                                                        class="text-center align-middle">Lokasi Absen
                                                                    </th>
                                                                    <th rowspan="2"
                                                                        class="text-center align-middle">Jam Datang
                                                                        Kerja</th>
                                                                    <th rowspan="2"
                                                                        class="text-center align-middle">Jam Pulang
                                                                        Kerja</th>
                                                                    <th colspan="2" class="text-center">Kordinat
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center">Latitude</th>
                                                                    <th class="text-center">Longitude</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>

                                                                    <td class="text-center"><input type="text"
                                                                            class="form-control form-control-sm"
                                                                            name="sistem_absensi"
                                                                            value="{{ $emp->sistem_absensi }}"></td>
                                                                    <td class="text-center"><input type="text"
                                                                            class="form-control form-control-sm"
                                                                            name="loc"
                                                                            value="{{ $emp->loc }}">
                                                                    </td>
                                                                    <td class="text-center"><input type="text"
                                                                            class="form-control"
                                                                            name="start_work_user"
                                                                            value="{{ $emp->start_work_user }}"></td>
                                                                    <td class="text-center"><input type="text"
                                                                            class="form-control" name="end_work_user"
                                                                            value="{{ $emp->end_work_user }}"></td>
                                                                    <td class="text-center"><input type="text"
                                                                            class="form-control" name="latitude"
                                                                            value="{{ $emp->latitude }}"></td>
                                                                    <td class="text-center"><input type="text"
                                                                            class="form-control" name="longitude"
                                                                            value="{{ $emp->longitude }}"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <h5 class="mt-3">Status Karyawan</h5>
                                                <div class="card">
                                                    <div class="body">

                                                        <table
                                                            class="table table-bordered table-striped table-responsive table-hover">
                                                            <thead>

                                                                <tr>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Status</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        No.
                                                                        Approval</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Mulai
                                                                        Kerja</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Tanggal Keluar</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Masa
                                                                        Kerja <br> (thn)</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Tanggal <br> Persetujuan <br> Resign</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Tanggal <br> Keluar <br> Dokumen</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Tanggal <br> Terima <br> Pesangon</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Jumlah <br> Hari <br> Proses</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Reason</th>
                                                                    <th class=""
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Jumlah Pesangon</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <input type="hidden" name="nik"
                                                                            value="{{ $emp->nik }}">
                                                                        <select name="status_active" id=""
                                                                            class="form-control form-control-sm">
                                                                            <option value="" selected disabled>--
                                                                                Pilih Status --</option>
                                                                            <option value="yes">Aktif</option>
                                                                            <option value="no">Tidak Aktif
                                                                            </option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            name="no_approval">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            name="start_worked" readonly
                                                                            value="{{ $emp->start }}"
                                                                            id="start_worked">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="date"
                                                                            class="form-control form-control-sm"
                                                                            name="date_out" id="date_out">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            name="work_period" id="work_period">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="date"
                                                                            class="form-control form-control-sm"
                                                                            name="date_resign_approval">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="date"
                                                                            class="form-control form-control-sm"
                                                                            name="date_out_document">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="date"
                                                                            class="form-control form-control-sm"
                                                                            name="date_severance_pay">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            name="total_day_process">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            name="reason">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            name="total_severance_pay"
                                                                            id="total_severance_pay">
                                                                    </td>
                                                                </tr>
                                                                @forelse ($resigns as $item)
                                                                    <tr>
                                                                        <td>{{ $item->user->active == 'no' ? 'tidak aktif' : 'aktif' }}
                                                                        </td>
                                                                        <td>{{ $item->no_approval }}</td>
                                                                        <td>{{ $item->start_work }}</td>
                                                                        <td>{{ $item->date_out }}</td>
                                                                        <td>{{ $item->work_period }}</td>
                                                                        <td>{{ $item->date_resign_approval }}</td>
                                                                        <td>{{ $item->date_out_document }}</td>
                                                                        <td>{{ $item->date_severance_pay }}</td>
                                                                        <td>{{ $item->total_day_process }}</td>
                                                                        <td>{{ $item->reason }}</td>
                                                                        <td>{{ $item->total_severance_pay }}</td>
                                                                        <td>{{ $item->remark }}</td>
                                                                        <td>
                                                                            <input type="hidden" name="id_resign"
                                                                                value="{{ $item->id }}">
                                                                            <button class="btn btn-danger btn-sm"
                                                                                name="action"
                                                                                value="del-resign">DEL</button>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td>No data</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        <button class="btn btn-primary btn-sm mr-2"
                                                            style="float: right;" name="action"
                                                            value="resign">Simpan</button>
                                                    </div>
                                                </div>

                                                <h5 class="mt-3">Riwayat Pekerjaan</h5>
                                                <div class="card">
                                                    <div class="body">
                                                        <table class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center" colspan="3"
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Periode (Bln-Thn)</th>
                                                                    <th rowspan="2"
                                                                        class="align-middle text-center"
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Jabatan/ Posisi</th>
                                                                    <th rowspan="2"
                                                                        class="align-middle text-center"
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Grade</th>
                                                                    <th rowspan="2"
                                                                        class="align-middle text-center"
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Status</th>
                                                                    <th rowspan="2"
                                                                        class="align-middle text-center"
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Divisi</th>
                                                                </tr>
                                                                <tr>
                                                                    <th
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Awal</th>
                                                                    <th
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Akhir</th>
                                                                    <th
                                                                        style="background: rgb(210, 210, 210); color: black;">
                                                                        Lamanya <br> (bln)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <td class="text-center">
                                                                    <input type="hidden" name="nik_riw"
                                                                        value="{{ $emp->nik }}">
                                                                    <input type="month"
                                                                        class="form-control form-control-sm"
                                                                        name="start" id="start">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="month"
                                                                        class="form-control form-control-sm"
                                                                        name="end" id="end">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="duration" id="duration" readonly>
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="position" id=""
                                                                        class="form-control form-control-sm">
                                                                        <option value="" selected disabled>--
                                                                            pilih jabatan --</option>
                                                                        @foreach ($position as $item)
                                                                            <option value="{{ $item->position }}">
                                                                                {{ $item->position }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="grade_history" id="" class="form-control form-control-sm">
                                                                        <option value="{{ $emp->grade }}">{{ ($emp->grade) ? $emp->grade : '-- pilih --' }}</option>
                                                                        <option value="">Non Grade</option>
                                                                        @foreach ($grade as $item)
                                                                            <option value="{{ $item->grade }}">{{ $item->grade }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="status_history" id=""
                                                                        class="form-control form-control-sm">
                                                                        <option value="" selected disabled>--
                                                                            pilih status --</option>
                                                                        @foreach ($status as $item)
                                                                            <option value="{{ $item->status }}">
                                                                                {{ $item->status }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <select name="division" id=""
                                                                        class="form-control form-control-sm">
                                                                        <option value="" selected disabled>--
                                                                            pilih divisi --</option>
                                                                        @foreach ($dept as $item)
                                                                            <option value="{{ $item->dept }}">
                                                                                {{ $item->dept }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                @forelse ($work_histories as $item)
                                                                    <tr>
                                                                        <td>{{ \Carbon\Carbon::parse($item->start)->format('M-Y') }}
                                                                        </td>
                                                                        <td>{{ \Carbon\Carbon::parse($item->end)->format('M-Y') }}
                                                                        </td>
                                                                        <td>{{ $item->duration }}</td>
                                                                        <td>{{ $item->position }}</td>
                                                                        <td>{{ $item->grade }}</td>
                                                                        <td>{{ $item->status }}</td>
                                                                        <td>{{ $item->division }}</td>
                                                                        <td>{{ $item->remark }}</td>
                                                                        <td>
                                                                            <input type="hidden" name="id_work"
                                                                                value="{{ $item->id }}">
                                                                            <button class="btn btn-danger btn-sm"
                                                                                name="action"
                                                                                value="del-work">DEL</button>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td>No data</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        <button class="btn btn-primary btn-sm mr-2"
                                                            style="float: right;" name="action"
                                                            value="history">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>


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
    <script>
        $(document).ready(function() {
            // Show the modal when the button is clicked
            $('#showModalBtn').click(function() {
                $('#exampleModal').modal('show');
            });

            $('#yesBtn').click(function() {
                // Toggle the visibility of the date input field
                $('#date_mutation').toggle();
                $('#update_mutation').toggle();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#end').on('change', function() {
                // Get the values from the input fields
                var startMonthStr = $('#start').val();
                var endMonthStr = $('#end').val();

                // Convert the string values to Date objects
                var startMonth = new Date(startMonthStr + "-01");
                var endMonth = new Date(endMonthStr + "-01");

                // Calculate the total number of months
                var totalMonths = (endMonth.getFullYear() - startMonth.getFullYear()) * 12 + (endMonth
                    .getMonth() - startMonth.getMonth());


                // Display the result
                $('#duration').val(totalMonths);
            });

            $('#date_out').on('change', function() {
                // Get the values from the input fields
                var startMonthStr = $('#start_worked').val();
                var endMonthStr = $('#date_out').val();

                // Convert the string values to Date objects
                var startMonth = new Date(startMonthStr);
                var endMonth = new Date(endMonthStr);

                // Calculate the total number of months
                var totalMonths = (endMonth.getFullYear() - startMonth.getFullYear());


                // Display the result
                $('#work_period').val(totalMonths);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to add commas as a separator for numbers
            function addCommas(input) {
                return input.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Function to remove commas when getting the value
            function removeCommas(input) {
                return input.replace(/,/g, "");
            }

            // Event listener for input changes
            $('#total_severance_pay').on('input', function() {
                // Get the input value without commas
                var inputValue = removeCommas($(this).val());

                // Add commas for better visualization
                var formattedValue = addCommas(inputValue);

                // Update the input value with commas
                $(this).val(formattedValue);
            });
        });
    </script>

</body>
