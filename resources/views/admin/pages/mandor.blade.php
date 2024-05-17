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

                        <div class="card">
                            <div class="card">
                                <form action="{{ route('import-kemandoran') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label>Pilih file excel</label>
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="file" required="required">

                                        <button class="btn btn-success mt-3" type="submit"
                                            id="btn-import">Import</button>
                                    </div>
                                </form>
                                <div class="form-group">
                                    <a href="{{ route('input-mandor') }}" class="btn btn-primary btn-sm">Input
                                        Kemandoran</a>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">

                            <div class="action-form mb-2">
                                <form action="{{ route('delete-mandor') }}" method="post">
                                    @csrf
                                    <tr>
                                        <td>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                        <td>
                                            <input type="hidden" name="id_check" id="id_check">
                                        </td>
                                    </tr>
                                </form>
                            </div>

                            <div class="table-responsive p-0" style="height:500px; overflow:auto;">
                                <table
                                    class="table table-striped table-hover table-bordered table-sm align-items-center mb-0"
                                    id="tab">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                NIK</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $item => $mandor)
                                            <tr>
                                                <th colspan="3" class="text-center">
                                                    <h5>Mandor: {{ $item }}</h5>
                                                </th>
                                            </tr>
                                            @foreach ($mandor as $itemx)
                                                <tr>
                                                    <td><a href="" class="btn btn-secondary btn-sm"
                                                            style="margin-bottom: -2px;">Ubah</a></td>
                                                    <td>{{ $itemx->user_subs->nik }}</td>
                                                    <td>{{ $itemx->user_subs->name }}</td>
                                                    <td>
                                                        <input type="checkbox" class="check_id" name="check_id"
                                                            id="check_id" value="{{ $itemx->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
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
    <script>
        $(function() {
            $('.check_id').change(function() {
                if ($(this).is(':checked')) {
                    var favProgramming = [];
                    $.each($("input[name='check_id']:checked"), function() {
                        favProgramming.push($(this).val());
                    });
                    $('#id_check').val(favProgramming);
                }
            });
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
