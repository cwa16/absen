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
                                <h3 class="text-white text-capitalize ps-3">Detail Data Training</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <a class="btn btn-secondary" href="{{ URL::previous() }}">Back</a>
                                    <form action="{{ route('filter-data-detail-training') }}" method="POST">
                                        <table class="table">
                                            @csrf
                                            <tr>
                                                <th>Category</th>
                                                <th>Topic</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" name="category" id="category">
                                                        <option value="" selected disabled>-- Select Category --
                                                        </option>
                                                        @foreach ($category as $item)
                                                            <option value="{{ $item->category }}">{{ $item->category }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="topic" id="topic">
                                                        <option value=""></option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <div class="mt-2" style="overflow: auto;">
                                        <table class="table table-bordered table-striped table-hover table-sm tablex" id="tablex">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="align-middle text-center">No.</th>
                                                    <th rowspan="2" class="align-middle text-center">NIK</th>
                                                    <th rowspan="2" class="align-middle text-center">Nama</th>
                                                    <th rowspan="2" class="align-middle text-center">Dept.</th>
                                                    <th rowspan="2" class="align-middle text-center">Posisi</th>
                                                    <th colspan="2" class="align-middle text-center">Pelaksanaan</th>
                                                    <th rowspan="2" class="align-middle text-center">Score</th>
                                                    <th rowspan="2" class="align-middle text-center">Trainer</th>
                                                    <th rowspan="2" class="align-middle text-center">No. Record</th>
                                                </tr>
                                                <tr>
                                                    <th>From</th>
                                                    <th>To</th>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#category').click(function() {
                $.ajax({
                    url: '{{ route('select-cat') }}',
                    method: 'POST',
                    data: {
                        category: $(this).val()
                    },
                    success: function(response) {
                        $('#topic').empty();

                        $.each(response.topic, function(data, data) {
                            $('#topic').append(new Option(data, data))
                        })
                    }
                });
            });

            $('#topic').click(function() {
                $.ajax({
                    url: '{{ route('filter-data-detail-training-jquery') }}',
                    method: 'POST',
                    data: {
                        category: $('#category').val(),
                        topic: $('#topic').val(),
                    },
                    success: function (response) {
                        $('.tablex > tbody').empty();

                        $.each(response.data, function (key, data) {
                            $('.tablex > tbody:last-child').append('<tr><td>' + ++key + '</td><td>' + data.nik + '</td><td>' + data.name + '</td><td>' + data.dept + '</td><td>' + data.jabatan + '</td><td>' + data.from_date + '</td><td>' + data.to_date + '</td><td>' + data.score + '</td><td>' + data.trainers + '</td><td>' + data.id_data + '</td></tr>')
                        })
                    }
                })
            })
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
