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
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <input type="hidden" name="id"
                                                                value="{{ $emp->id }}">
                                                            <td>
                                                                <select name="active" id=""
                                                                    class="form-control form-control-sm">
                                                                    <option value="{{ $emp->active }}" selected
                                                                        disabled>{{ $emp->active }}</option>
                                                                    <option value="yes">Yes</option>
                                                                    <option value="no">No</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="nik"
                                                                    value="{{ $emp->nik }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="name"
                                                                    value="{{ $emp->name }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="dept"
                                                                    value="{{ $emp->dept }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="jabatan"
                                                                    value="{{ $emp->jabatan }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="email"
                                                                    value="{{ $emp->email }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="loc_kerja" value="{{ $emp->loc_kerja }}">
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
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="sex" value="{{ $emp->sex }}">
                                                                </td>
                                                                <th>No. Telpon</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="no_telpon" value="{{ $emp->no_telpon }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="status" value="{{ $emp->status }}">
                                                                </td>
                                                                <th>KIS</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="kis" value="{{ $emp->kis }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Grade</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="grade" value="{{ $emp->grade }}">
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
                                                                        name="start" value="{{ $emp->start }}">
                                                                </td>
                                                                <th>Aktual Cuti</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="aktual_cuti"
                                                                        value="{{ $emp->aktual_cuti }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pendidikan</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="pendidikan"
                                                                        value="{{ $emp->pendidikan }}"></td>
                                                                <th>Status Pernikahan</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="status_pernikahan"
                                                                        value="{{ $emp->status_pernikahan }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Agama</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="agama" value="{{ $emp->agama }}">
                                                                </td>
                                                                <th>Istri /Suami</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="istri_suami"
                                                                        value="{{ $emp->istri_suami }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Suku</th>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="suku" value="{{ $emp->suku }}">
                                                                </td>
                                                                <th>Anak</th>
                                                                <td>1. <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="anak_1" value="{{ $emp->anak_1 }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Lokasi Absen</th>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="loc" value="{{ $emp->loc }}">
                                                                </td>
                                                                <td>2. <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="anak_2" value="{{ $emp->anak_2 }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Sistem Absen</th>
                                                                <td colspan="2"><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="sistem_absensi"
                                                                        value="{{ $emp->sistem_absensi }}"></td>
                                                                <td>3. <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="anak_3" value="{{ $emp->anak_3 }}">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <br>
                                                        <button class="btn btn-primary text-right">UPDATE</button>
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
                                                <div class="card mt-3">
                                                    <div class="body">
                                                        <table
                                                            class="table table-bordered table-striped table-responsive table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="4" class="">Status Karyawan
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="">Aktif</th>
                                                                    <th class="">Tanggal</th>
                                                                    <th class="">Keterangan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
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
