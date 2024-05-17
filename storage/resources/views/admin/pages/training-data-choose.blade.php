@include('admin.includes.head')
{{-- <link rel="stylesheet" href="{{ ('https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css') }}"> --}}

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
                                <h6 class="text-white text-capitalize ps-3">Pilih Dept</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <a class="btn btn-secondary" href="{{ URL::previous() }}">Back</a>
                                    <div class="alert alert-light" role="alert">
                                        Silahkan pilih atau block per departemen yang akan dimasukkan kedalam data
                                        training kemudian klik tombol LOAD DATA
                                    </div>
                                    <div class="row">
                                        <form action="{{ route('loadDept') }}" method="post">
                                            @csrf
                                            <div class="col">
                                                <label for="">Position</label>
                                                <select class="form-select mb-2" name="jabatan[]" id="jabatan" multiple
                                                    aria-label="multiple select example" style="height: 200px;">
                                                    @foreach ($dept as $item)
                                                        <option value="{{ $item->jabatan }}">{{ $item->jabatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="">Departement</label>
                                                <select class="form-select mb-2" name="dept[]" id="dept"
                                                    multiple aria-label="multiple select example"
                                                    style="height: 200px;">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary form-control">Load Data</button>
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
    {{-- <script src="{{ ('https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js') }}"></script> --}}
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#jabatan').click(function() {
                $.ajax({
                    url: '{{ route('select-emp') }}',
                    method: 'POST',
                    data: {
                        jabatan: $(this).val()
                    },
                    success: function(response) {
                        $('#dept').empty();

                        $.each(response, function(data, data) {
                            $('#dept').append(new Option(data, data))
                        })
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#table-data').DataTable();
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
