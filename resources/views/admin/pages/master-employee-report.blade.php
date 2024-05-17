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
                                <h6 class="text-white text-capitalize ps-3">Employee List Report</h6>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('print-list-report') }}" method="post" target="_blank">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Filter</label>
                                            <select name="filter_by" id="" class="form-control">
                                                <option value="all">All</option>
                                                <option value="NEO">New Employee Only</option>
                                                <option value="EAO">Employee Active Only</option>
                                                <option value="ENAO">Employee Non Active Only</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="">Sorted</label>
                                            <select name="sorted" id="" class="form-control">
                                                <option value="status_dept">Status & Departement</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="" />
                                                <label class="form-check-label" for=""> Tobe Retirement </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="" name="resigned"/>
                                                <label class="form-check-label" for=""> Resigned </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="" name="monthly" />
                                                <label class="form-check-label" for=""> Monthly </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-primary" name="action" value="preview">Preview</button>
                                            <button class="btn btn-info" name="action" value="print">Print</button>
                                            <button class="btn btn-success" name="action" value="export">Excel</button>
                                        </div>
                                    </div>
                                </form>
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
