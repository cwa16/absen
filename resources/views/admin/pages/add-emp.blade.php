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
                                <h6 class="text-white text-capitalize ps-3">Add Employee</h6>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('store-emp') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <table class="table table-striped table-responsive table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Employee Code</th>
                                                            <th>Nama</th>
                                                            <th>Departement</th>
                                                            <th>Jabatan</th>
                                                            <th>Email</th>
                                                            <th>Lokasi Kerja</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="nik"
                                                                    placeholder="cth: 123-456" required></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="name"
                                                                    placeholder="Nama Lengkap" required></td>
                                                            <td>
                                                                <select name="dept" id=""
                                                                    class="form-control form-control-sm">
                                                                    <option value="" selected disabled>-- Pilih
                                                                        Departemen</option>
                                                                    @foreach ($dept as $item)
                                                                        <option value="{{ $item->dept }}">
                                                                            {{ $item->dept }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="jabatan" id=""
                                                                    class="form-control form-control-sm">
                                                                    <option value="" selected disabled>-- Pilih
                                                                        Jabatan</option>
                                                                    @foreach ($position as $item)
                                                                        <option value="{{ $item->jabatan }}">
                                                                            {{ $item->jabatan }} ({{ $item->alias }})</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="email"
                                                                    placeholder="Email"></td>
                                                            <td>
                                                                <select name="loc_kerja" id=""
                                                                    class="form-control form-control-sm">
                                                                    <option value="" selected disabled>-- Pilih
                                                                        Lokasi Kerja</option>
                                                                    @foreach ($location as $item)
                                                                        <option value="{{ $item->location }}">
                                                                            {{ $item->location }}</option>
                                                                    @endforeach
                                                                </select>
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
                                                        <img src="" alt=""
                                                            style="width: 400px; height: 400px;">
                                                        <div class="input-group mb-3">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlFile1">Masukkan gambar
                                                                    disini</label>
                                                                <input type="file" class="form-control-file"
                                                                    id="exampleFormControlFile1" name="file">
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
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="domisili" placeholder="cth: Banjarbaru">
                                                                </td>
                                                                <th>No. KTP</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="no_ktp" placeholder="cth: 310000001200"
                                                                        required></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Sex</th>
                                                                <td><select class="form-control form-control-sm"
                                                                        name="sex" required>
                                                                        <option selected disabled>-- Pilih Jenis Kelamin
                                                                            --
                                                                        </option>
                                                                        <option value="F">Wanita</option>
                                                                        <option value="M">Pria</option>
                                                                    </select>
                                                                </td>
                                                                <th>No. Telpon</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="no_telpon" placeholder="cth: 08512348483">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status</th>
                                                                <td><select class="form-control form-control-sm"
                                                                        name="status" required>
                                                                        <option selected disabled>-- Pilih Status --
                                                                        </option>
                                                                        <option value="Staff">Staff</option>
                                                                        <option value="Monthly">Monthly</option>
                                                                        <option value="Regular">Regular</option>
                                                                        <option value="Contract BSKP">Contract BSKP</option>
                                                                        <option value="Contract FL">Contract FL</option>
                                                                    </select></td>
                                                                <th>KIS</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="kis" placeholder="cth: 123142323">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Grade</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="grade" placeholder="cth: IID"></td>
                                                                <th>KPJ</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="kpj" placeholder="cth: 1234566778">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>TTL</th>
                                                                <td><input type="date"
                                                                        class="form-control form-control-sm"
                                                                        name="ttl" required>
                                                                </td>
                                                                <th>No. Sepatu Safety</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="no_sepatu_safety" placeholder="cth: 42">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Mulai Kerja</th>
                                                                <td><input type="date"
                                                                        class="form-control form-control-sm"
                                                                        name="start" required>
                                                                </td>
                                                                <th>Kemandoran</th>
                                                                <td>
                                                                    <select name="kemandoran" id="" class="form-control form-control-sm">
                                                                        <option value="" selected disabled>-- Pilih Kemandoran --</option>
                                                                        @foreach ($kemandoran as $item)
                                                                            <option value="{{ $item->nik }}">{{ $item->nik }} | {{ $item->name }} | {{ $item->dept }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pendidikan</th>
                                                                <td>
                                                                    <select name="pendidikan" id=""
                                                                        class="form-control form-control-sm">
                                                                        <option value="" selected disabled>--
                                                                            Pilih Pendidikan --</option>
                                                                        @foreach ($education as $item)
                                                                            <option value="{{ $item->education }}">
                                                                                {{ $item->education }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <th>Status Pernikahan</th>
                                                                <td><select class="form-control form-control-sm"
                                                                        name="status_pernikahan">
                                                                        <option selected disabled>-- Pilih Status
                                                                            Pernikahan
                                                                            --</option>
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
                                                                        <option selected disabled>-- Pilih Agama --
                                                                        </option>
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
                                                                        placeholder="Nama Suami/ Istri"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Suku</th>
                                                                <td>
                                                                    <select name="suku" id="" class="form-control form-control-sm">
                                                                        <option value="" selected disabled>-- Pilih Suku</option>
                                                                        <option value="Banjar">Banjar</option>
                                                                        <option value="Jawa">Jawa</option>
                                                                        <option value="Dayak">Dayak</option>
                                                                        <option value="Flores">Flores</option>
                                                                        <option value="Bugis">Bugis</option>
                                                                        <option value="Lombok">Lombok</option>
                                                                        <option value="Madura">Madura</option>
                                                                        <option value="Sunda">Sunda</option>
                                                                        <option value="Timur-Timur">Timur-Timur</option>
                                                                    </select>
                                                                </td>
                                                                <th>Anak</th>
                                                                <td>1. <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="anak_1"
                                                                        placeholder="Nama Anak Pertama">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>No. Baju</th>
                                                                <td>
                                                                    <select name="no_baju" id=""
                                                                        class="form-control form-control-sm">
                                                                        <option value="" selected disabled>-- pilih ukuran --
                                                                        </option>
                                                                        <option value="s">S</option>
                                                                        <option value="m">M</option>
                                                                        <option value="l">L</option>
                                                                        <option value="xl">XL</option>
                                                                        <option value="xxl">XXL</option>
                                                                        <option value="xxxl">XXXL</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Bank Name</th>
                                                                <td colspan="2">
                                                                    <select name="bank" id="" class="form-control form-control-sm">
                                                                        <option value="" selected disabled>-- Pilih Bank --</option>
                                                                        <option value="Mandiri">Bank Mandiri</option>
                                                                        <option value="BSI">Bank BSI</option>
                                                                        <option value="BRI">Bank BRI</option>
                                                                        <option value="BNI">Bank BNI</option>
                                                                        <option value="BTN">Bank BTN</option>
                                                                        <option value="BCA">Bank BCA</option>
                                                                    </select>
                                                                </td>
                                                                <td>2. <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="anak_2" placeholder="Nama Anak Kedua">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Account Number</th>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="no_bank">
                                                                </td>
                                                                <td>3. <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="anak_3" placeholder="Nama Anak Ketiga">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <br>
                                                        <button class="btn btn-primary text-right"
                                                            type="submit">SAVE</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="card mt-3">
                                                    <div class="body">
                                                        <table
                                                            class="table table-bordered table-striped table-responsive table-hover">
                                                            <thead>
                                                                <tr>
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
                                                                            class="form-control"
                                                                            name="start_work_user"></td>
                                                                    <td class="text-center"><input type="text"
                                                                            class="form-control" name="end_work_user">
                                                                    </td>
                                                                    <td class="text-center"><input type="text"
                                                                            class="form-control" name="latitude"></td>
                                                                    <td class="text-center"><input type="text"
                                                                            class="form-control" name="longitude">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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

</body>
