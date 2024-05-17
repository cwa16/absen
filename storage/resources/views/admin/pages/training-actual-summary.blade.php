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
                                <h6 class="text-white text-capitalize ps-3">Summary Actual Training</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <a class="btn btn-secondary" href="{{ URL::previous() }}">Back</a>
                                            <div class="table" style="overflow: auto;">
                                                <table
                                                    class="table table-bordered table-striped table-responsive table-hover table-sm"
                                                    id="table-data">
                                                    <thead>
                                                        <tr class="text-center" style="background-color: orange;">
                                                            <th>No.</th>
                                                            <th>Month</th>
                                                            <th>Internal/External</th>
                                                            <th>Trainer by (Institution/Dept.)</th>
                                                            <th>Topic Training</th>
                                                            <th>No. Record (In-house education/ TEE)</th>
                                                            <th>No of Trainee</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($data as $key => $item)
                                                            <tr class="align-middle text-center">
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($item->from_date)->format('F') }}
                                                                </td>
                                                                <td>{{ $item->kind }}</td>
                                                                <td>{{ $item->user->name }} / {{ $item->user->dept }}
                                                                </td>
                                                                <td>{{ $item->topic }}
                                                                </td>
                                                                <td>{{ $item->id_data }}
                                                                </td>
                                                                <td>{{ $item->attTrainings->count() }}</td>
                                                                <td></td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="10" class="text-center">No data</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table" style="overflow: auto;">
                                                <table
                                                    class="table table-bordered table-striped table-sm align-middle text-center">
                                                    <thead>
                                                        <tr style="background-color: orange;">
                                                            <th rowspan="2" class="align-middle">Internal/External
                                                            </th>
                                                            <th rowspan="2" class="align-middle">Trainer by
                                                                (Institution/Dept)</th>
                                                            <th colspan="6">Topic Training</th>
                                                            <th rowspan="2" class="align-middle">Total</th>
                                                        </tr>
                                                        <tr style="background-color: orange;"">
                                                            <th>S</th>
                                                            <th>E</th>
                                                            <th>Q</th>
                                                            <th>HSEQ</th>
                                                            <th>HRD & Legal</th>
                                                            <th>IT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($training as $item)
                                                            <tr id="idtr">
                                                                <td>{{ $item->kind }}</td>
                                                                <td>{{ $item->user->name }} / {{ $item->user->dept }}
                                                                </td>
                                                                <td class="idsafety">
                                                                    {{ $item->category == 'Safety' ? $item->where('category', 'Safety')->count() : 0 }}
                                                                </td>
                                                                <td class="idenviro">
                                                                    {{ $item->category == 'Enviro' ? $item->where('category', 'Enviro')->count() : 0 }}
                                                                </td>
                                                                <td class="idquality">
                                                                    {{ $item->category == 'Quality' ? $item->where('category', 'Quality')->count() : 0 }}
                                                                </td>
                                                                <td class="idhseq">
                                                                    {{ $item->category == 'HSEQ' ? $item->where('category', 'HSEQ')->count() : 0 }}
                                                                </td>
                                                                <td class="idhrd_legal">
                                                                    {{ $item->category == 'HRD & Legal' ? $item->where('category', 'HRD & Legal')->count() : 0 }}
                                                                </td>
                                                                <td class="idit">
                                                                    {{ $item->category == 'IT' ? $item->where('category', 'IT')->count() : 0 }}
                                                                </td>
                                                                <td class="idtotal">
                                                                    {{ $item->where('trainer', $item->trainer)->count() }}
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
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
    {{-- <script src="{{ ('https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('#table-data').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            calculateAndDisplayTotal();
        });

        function calculateAndDisplayTotal() {
            var total = 0;
            $('.idtr').each(function() {
                sf = parseInt($('.idsafety').text());
                ev = parseInt($('.idenviro').text());
                qt = parseInt($('.idquality').text());
                hseq = parseInt($('.idhseq').text());
                hrlegal = parseInt($('idhrd_legal').text());
                it = parseInt($('.idit').text());

                total = sf+ev+qt+hseq+hrlegal+it;
                console.log(total);
                $('.idtotal').text(total);
            });


        }
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
