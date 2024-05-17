@include('admin.includes.head')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

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
                                <h6 class="text-white text-capitalize ps-3">Input Medical Check Up</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table table-bordered table-hover table-sm">
                                            <tr>
                                                <td><b>Date</b></td>
                                            </tr>
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <form action="{{ route('store-drug-input') }}" method="post">
                                            @csrf
                                            <table class="table table-bordered table-hover table-sm" id="table-data">
                                                <tr>
                                                    <td colspan="3" class="text-center"><b>Input Data</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Karyawan</td>
                                                    <td>Hasil</td>
                                                    <td>Action</td>
                                                </tr>
                                                <tr class="tr_clone">
                                                    <td>
                                                        <input type="hidden" name="id"
                                                            value="{{ $data->id }}">
                                                        <select name="nik[]" id=""
                                                            class="form-control select-emp">
                                                            <option selected disabled>-- Pilih Karyawan --</option>
                                                            @foreach ($user as $item)
                                                                <option value="{{ $item->nik }}">{{ $item->nik }}
                                                                    - {{ $item->name }} | {{ $item->dept }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="result[]" id=""
                                                            class="form-control">
                                                    </td>
                                                    <td>
                                                        <a id="add-btn"
                                                            class="btn btn-primary btn-sm tr_clone_add">+</a>
                                                        <a id="add-btn"
                                                            class="btn btn-warning btn-sm tr_clone_remove">-</a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="row">
                                                <button class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
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
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select-emp').select2();
        });
    </script>
    <script>
        $('#table-data').on('click', '.tr_clone_add', function() {
            $(this).closest('.tr_clone').find(".select-emp").select2("destroy");
            var $tr = $(this).closest('.tr_clone');
            var $clone = $tr.clone();
            $clone.find(':text').val('');
            $tr.after($clone);
            $(".select-emp").select2();
        });

        $('#table-data').on('click', '.tr_clone_remove', function() {
            $tr = $(this).closest("tr").remove();
            $('.select-emp').select2();
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
