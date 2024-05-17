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
                                <h6 class="text-white text-capitalize ps-3">Master Employee</h6>
                            </div>
                        </div>

                        <!-- boostrap add and edit book model -->
                        <div class="modal fade" id="ajax-book-model" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="ajaxBookModel"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm"
                                            class="form-horizontal" method="POST">
                                            <input type="hidden" name="id" id="id">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Name</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="names"
                                                        name="names" placeholder="Enter Employee Name" maxlength="50"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Start Work</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" id="start_work"
                                                        name="start_work" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">End Work</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" id="end_work"
                                                        name="end_work" />
                                                </div>
                                            </div>
                                            <div class="col-sm-offset-2 col-sm-10 mt-3">
                                                <button type="submit" class="btn btn-primary" id="btn-save"
                                                    value="addNewBook">Update Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        <!-- boostrap add and edit book model -->
                        <div class="modal fade modal-att" id="ajax-book-model-att" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="ajaxBookModelAtt">End Work Photo Information</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img class="form-control" src="" alt="" id="img-atts">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        <div class="card">
                            <div class="card">
                                <form action="{{ route('user-import') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <label>Pilih file excel</label>
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="file" required="required">

                                        <button class="btn btn-success mt-3" type="submit"
                                            id="btn-import">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="card-body">
                            <a href="{{ route('add-emp') }}" class="btn btn-primary">TAMBAH</a>
                            <div class="table-responsive p-0">
                                <table class="table table-striped table-sm align-items-center mb-0"
                                    id="table-attendance-now" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Emp. Code</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Grade</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Dept.</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jabatan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Sex</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                TTL</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Mulai Kerja</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Pendidikan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Agama</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Domisili</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Email</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No. KTP</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No. Telpon</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                KIS</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                KPJ</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Suku</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No. Sepatu Safety</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Start Work User</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                End Work User</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Lokasi Kerja</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Lokasi Absen</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Sistem Absen</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Latitude</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Longitude</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Aktual Cuti</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Status Pernikahan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Istri/Suami</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Anak 1</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Anak 2</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Anak 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
        $(function() {

            $('*[name=start_work]').appendDtpicker();
            $('*[name=end_work]').appendDtpicker();

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#table-attendance-now').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('master-employee') }}",
                columns: [{
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'grade',
                        name: 'grade'
                    },
                    {
                        data: 'dept',
                        name: 'dept'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'sex',
                        name: 'sex'
                    },
                    {
                        data: 'ttl',
                        name: 'ttl'
                    },
                    {
                        data: 'start',
                        name: 'start'
                    },
                    {
                        data: 'pendidikan',
                        name: 'pendidikan'
                    },
                    {
                        data: 'agama',
                        name: 'agama'
                    },
                    {
                        data: 'domisili',
                        name: 'domisili'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'no_ktp',
                        name: 'no_ktp'
                    },
                    {
                        data: 'no_telpon',
                        name: 'no_telpon'
                    },
                    {
                        data: 'kis',
                        name: 'kis'
                    },
                    {
                        data: 'kpj',
                        name: 'kpj'
                    },
                    {
                        data: 'suku',
                        name: 'suku'
                    },
                    {
                        data: 'no_sepatu_safety',
                        name: 'no_sepatu_safety'
                    },
                    {
                        data: 'start_work_user',
                        name: 'start_work_user'
                    },
                    {
                        data: 'end_work_user',
                        name: 'end_work_user'
                    },
                    {
                        data: 'loc_kerja',
                        name: 'loc_kerja'
                    },
                    {
                        data: 'loc',
                        name: 'loc'
                    },
                    {
                        data: 'sistem_absensi',
                        name: 'sistem_absensi'
                    },
                    {
                        data: 'latitude',
                        name: 'latitude'
                    },
                    {
                        data: 'longitude',
                        name: 'longitude'
                    },
                    {
                        data: 'aktual_cuti',
                        name: 'aktual_cuti'
                    },
                    {
                        data: 'status_pernikahan',
                        name: 'status_pernikahan'
                    },
                    {
                        data: 'istri_suami',
                        name: 'istri_suami'
                    },
                    {
                        data: 'anak_1',
                        name: 'anak_1'
                    },
                    {
                        data: 'anak_2',
                        name: 'anak_2'
                    },
                    {
                        data: 'anak_3',
                        name: 'anak_3'
                    },

                ]
            });
        });

        function deleteFunc(id) {
            if (confirm("Delete Record?") == true) {
                var id = id;
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-emp') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        var oTable = $('#table-attendance-now').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }
    </script>
</body>
