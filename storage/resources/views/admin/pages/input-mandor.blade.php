@include('admin.includes.head')
<link href="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' }}" rel="stylesheet" />

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
                                <h6 class="text-white text-capitalize ps-3">Input Kemandoran</h6>
                            </div>
                        </div>

                        <div class="card-body">
                           
                            <div class="row">
                                <div class="col">
                                   <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('store-mandor') }}" method="post">
                                            @csrf
                                            <div class="form-control">
                                                <label for="">Mandor</label>
                                                <select name="nik_mandor" id="nik_mandor" class="form-control">
                                                    @foreach ($data as $item)
                                                        <option value="{{$item->nik}}">{{ $item->nik }} - {{ $item->name }} ({{$item->dept}})</option>
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                            <div class="form-control mt-3">
                                                <label for="">Karyawan</label>
                                                <select name="nik_reg" id="nik_reg" class="form-control">
                                                    @foreach ($data as $item)
                                                        <option value="{{$item->nik}}">{{ $item->nik }} - {{ $item->name }} ({{$item->dept}})</option>
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                            <button class="btn btn-primary mt-3">Submit</button>
                                        </form>
                                    </div>
                                   </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive p-0">
                                                <table class="table table-striped table-sm align-items-center mb-0"
                                                    id="tab" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                NIK</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Name</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($user as $item => $mandor)
                                                            <tr>
                                                                <th colspan="3" class="text-center"><h5>Mandor: {{ $item }}</h5></th>
                                                            </tr>
                                                            @foreach ($mandor as $itemx)
                                                                <tr>
                                                                    <td>{{ $itemx->user_subs->nik }}</td>
                                                                    <td>{{ $itemx->user_subs->name }}</td>
                                                                    <td>
                                                                        <form action="{{ route('delete-mandor') }}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{ $itemx->id }}">
                                                                            <button class="btn btn-danger btn-sm">Delete</button>
                                                                        </form>
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
                           
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
    <script src="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js' }}"></script>
    <script>
        $(document).ready(function() {
            $('#nik_mandor').select2();
            $('#nik_reg').select2();
        });
    </script>
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
