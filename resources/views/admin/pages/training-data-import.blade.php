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
                                <h6 class="text-white text-capitalize ps-3">Import Data Training</h6>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('import-excel-judul') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="formFileSm" class="form-label">Import Judul</label>
                                            <input class="form-control form-control-sm" id="formFileSm" name="file"
                                                type="file" required>
                                            <button class="btn btn-primary btn-sm mt-2">Import Judul</button>
                                        </div>
                                    </form>
                                    <form action="{{ route('import-excel-peserta') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-2">
                                            <label for="formFileSm" class="form-label">Import Peserta</label>
                                            <input class="form-control form-control-sm" id="formFileSm" name="file"
                                                type="file" required>
                                            <button class="btn btn-primary btn-sm mt-2">Import Peserta</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="mt-2" style="overflow: auto">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>No. Record</th>
                                                <th>Jenis</th>
                                                <th>Judul</th>
                                                <th>Trainer</th>
                                                <th>Tanggal</th>
                                                <th>Tempat</th>
                                                <th>Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach ($data as $item)
                                                <tr class="align-middle">
                                                    <td>{{ ++$no }}</td>
                                                    <td>{{ $item->no }}</td>
                                                    <td>{{ $item->kind }}</td>
                                                    <td>{{ $item->topic }}</td>
                                                    <td>{{ $item->trainer_name }}</td>
                                                    <td>{{ $item->from_date }}
                                                    </td>
                                                    <td>{{ $item->place }}</td>
                                                    <td>{{ $item->category }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('print-training', $item->id_data) }}"
                                                            class="btn btn-warning"><i
                                                                class="fa-solid fa-print"></i></a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('edit-training', $item->id_data) }}"
                                                            class="btn btn-secondary"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('detail-training', $item->id_data) }}"
                                                            class="btn btn-primary"><i
                                                                class="fa-solid fa-eye"></i></a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('delete-training', $item->id_data) }}"
                                                            class="btn btn-danger"><i
                                                                class="fa-solid fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                ajax: "{{ route('master-training-emp') }}",
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
