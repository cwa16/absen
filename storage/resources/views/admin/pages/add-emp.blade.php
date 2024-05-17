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
                                <h6 class="text-white text-capitalize ps-3">Add Employee</h6>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('store-emp') }}" method="post" enctype="multipart/form-data">
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
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="nik" placeholder="cth: 123-456"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="name" placeholder="Nama Lengkap"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="dept" placeholder="Departemen"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="jabatan" placeholder="Jabatan"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="email" placeholder="Email"></td>
                                                        <td><input type="text" class="form-control form-control-sm"
                                                                name="loc_kerja" placeholder="Lokasi Kerja"></td>
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
                                                                    class="form-control form-control-sm" name="domisili"
                                                                    placeholder="cth: Banjarbaru"></td>
                                                            <th>No. KTP</th>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="no_ktp"
                                                                    placeholder="cth: 310000001200"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Sex</th>
                                                            <td><select class="form-control form-control-sm"
                                                                    name="sex">
                                                                    <option selected disabled>-- Pilih Jenis Kelamin --
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
                                                                    name="status">
                                                                    <option selected disabled>-- Pilih Status --
                                                                    </option>
                                                                    <option value="Staff">Staff</option>
                                                                    <option value="Monthly">Monthly</option>
                                                                    <option value="Regular">Regular</option>
                                                                    <option value="Regular">Kontrak</option>
                                                                </select></td>
                                                            <th>KIS</th>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="kis"
                                                                    placeholder="cth: 123142323"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Grade</th>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="grade"
                                                                    placeholder="cth: IID"></td>
                                                            <th>KPJ</th>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm" name="kpj"
                                                                    placeholder="cth: 1234566778"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>TTL</th>
                                                            <td><input type="date"
                                                                    class="form-control form-control-sm" name="ttl">
                                                            </td>
                                                            <th>No. Sepatu Safety</th>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="no_sepatu_safety" placeholder="cth: 42"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Mulai Kerja</th>
                                                            <td><input type="date"
                                                                    class="form-control form-control-sm" name="start">
                                                            </td>
                                                            <th>Aktual Cuti</th>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="aktual_cuti" placeholder="Aktual Cuti"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Pendidikan</th>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="pendidikan" placeholder="cth: S1"></td>
                                                            <th>Status Pernikahan</th>
                                                            <td><select class="form-control form-control-sm"
                                                                    name="status_pernikahan">
                                                                    <option selected disabled>-- Pilih Status Pernikahan
                                                                        --</option>
                                                                    <option value="S0">S0 (Belum Menikah)</option>
                                                                    <option value="K0">K0 (Menikah Belum Punya
                                                                        Anak)</option>
                                                                    <option value="K1">K1 (Menikah Anak 1)</option>
                                                                    <option value="K2">K2 (Menikah Anak 2)</option>
                                                                    <option value="K3">K3 (Menikah Anak 3)</option>
                                                                </select></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Agama</th>
                                                            <td><select class="form-control form-control-sm"
                                                                    name="agama">
                                                                    <option selected disabled>-- Pilih Agama --</option>
                                                                    <option value="Islam">Islam</option>
                                                                    <option value="Kristen Katolik">Kristen Katolik
                                                                    </option>
                                                                    <option value="Kristen Protestan">Kristen Protestan
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
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="suku" placeholder="Nama Suku"></td>
                                                            <th>Anak</th>
                                                            <td>1. <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="anak_1" placeholder="Nama Anak Pertama">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Lokasi Absen</th>
                                                            <td colspan="2"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="loc" placeholder="Lokasi Absen"></td>
                                                            <td>2. <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="anak_2" placeholder="Nama Anak Kedua"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Sistem Absen</th>
                                                            <td colspan="2"><select
                                                                    class="form-control form-control-sm"
                                                                    name="sistem_absensi">
                                                                    <option selected disabled>-- Pilih Sistem Absensi --
                                                                    </option>
                                                                    <option value="Aplikasi">Aplikasi</option>
                                                                    <option value="Manual">Manual</option>
                                                                </select></td>
                                                            <td>3. <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="anak_3" placeholder="Nama Anak Ketiga">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <button class="btn btn-primary text-right" type="submit">SAVE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col">
                                        <div class="card mt-3">
                                          <div class="body">
                                            <table class="table table-bordered table-striped table-responsive table-hover">
                                              <thead>
                                                <tr>
                                                  <th rowspan="2" class="text-center align-middle">Jam Datang Kerja</th>
                                                  <th rowspan="2" class="text-center align-middle">Jam Pulang Kerja</th>
                                                  <th colspan="2" class="text-center">Kordinat</th>
                                                </tr>
                                                <tr>
                                                  <th class="text-center">Latitude</th>
                                                  <th class="text-center">Longitude</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <td class="text-center"><input type="text" class="form-control" name="start_work_user"></td>
                                                  <td class="text-center"><input type="text" class="form-control" name="end_work_user"></td>
                                                  <td class="text-center"><input type="text" class="form-control" name="latitude"></td>
                                                  <td class="text-center"><input type="text" class="form-control" name="longitude"></td>
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
