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
                                <h6 class="text-white text-capitalize ps-3">Individual Training Record</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card text-start">
                                        <section class="header-top">
                                            <img src="{{ asset('assets/img/logo.png') }}" alt="Title" width="250px">
                                            <br>
                                            <b>PT. Bridgestone Kalimantan Plantation</b>
                                        </section>
                                        <div class="card-body">
                                            <div class="row">
                                                <h3 class="text-center">Individual Training Record</h3>
                                            </div>
                                            <div class="row">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td colspan="5" style="background-color: salmon; color:white;"><b>Data Diri</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Employee ID</td>
                                                            <td>: {{ $user->nik }}</td>
                                                            <td>Golongan</td>
                                                            <td>: {{ $user->grade }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Name</td>
                                                            <td>: {{ $user->name }}</td>
                                                            <td>Divisi</td>
                                                            <td>: {{ $user->dept }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Date Of Birth</td>
                                                            <td>: {{ $user->ttl }}</td>
                                                            <td>Jabatan</td>
                                                            <td>: {{ $user->jabatan }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sex</td>
                                                            <td>: {{ $user->sex }}</td>

                                                            <td>Mulai Kerja</td>
                                                            <td>: {{ \Carbon\Carbon::parse($user->start)->format('d F Y') }}</td>

                                                        </tr>
                                                        <tr>
                                                            <td>Pendidikan</td>
                                                            <td>: {{ $user->pendidikan }}</td>
                                                        </tr>
                                                    </table>
                                            </div>
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td colspan="7" style="background-color: salmon; color:white;"><b>Training</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>From Date</th>
                                                        <th>To Date</th>
                                                        <th>Subject</th>
                                                        <th>Trainer</th>
                                                        <th>Point</th>
                                                        <th>Location</th>
                                                        <th>Remark</th>
                                                    </tr>

                                                    @foreach ($trAtt as $item)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($item->from_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($item->to_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td>{{ $item->topic }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->score }}</td>
                                                            <td>{{ $item->place }}</td>
                                                            <td>{{ $item->ket }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            {{-- <div class="row">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td colspan="3" style="background-color: salmon; color:white;"><b>Pemeriksaan Kesehatan (MCU)</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Result</th>
                                                        <th>Remark</th>
                                                    </tr>

                                                    @foreach ($medic as $date => $item)
                                                        <tr>
                                                            <td class="align-middle" rowspan="4" style="width: 10px;">{{ \Carbon\Carbon::parse($date)->format('F Y') }}</td>
                                                        </tr>
                                                        @foreach ($item as $itemx)
                                                            <tr>
                                                                <td>{{ $itemx->result }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td colspan="3" style="background-color: salmon; color:white;"><b>Pemeriksaan Narkoba</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Result</th>
                                                        <th>Remark</th>
                                                    </tr>

                                                    @foreach ($drug as $date => $item)
                                                        <tr>
                                                            <td class="align-middle" rowspan="4" style="width: 10px;">{{ \Carbon\Carbon::parse($date)->format('F Y') }}</td>
                                                        </tr>
                                                        @foreach ($item as $itemx)
                                                            <tr>
                                                                <td>{{ $itemx->result }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </table>
                                            </div> --}}
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
