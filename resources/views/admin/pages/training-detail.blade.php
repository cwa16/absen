@include('admin.includes.head')

<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>


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
                                <h6 class="text-white text-capitalize ps-3">In-house Education/Training Record</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn btn-success" id="btn-d">Excel</button>
                                </div>
                            </div>
                            <div class="card mt-2">
                                <div class="card-body">
                                    <section class="kode" style="float: right;">
                                        <input type="text" value="{{ $dept->no }}" disabled>
                                    </section>

                                    <section class="header-inhouse text-center">
                                        <b>In-house Education/Training Record</b>
                                        <br>
                                        <b>Dept: {{ $dept->user->dept }}</b>
                                    </section>

                                    <table class="table-detail-training" id="myTablex">
                                        <tr>
                                            <td rowspan="2" colspan="4"><b>Judul Training :</b>
                                                {{ $dept->topic }}</td>
                                            <td><b>Tanggal Training</b></td>
                                            <td>{{ $dept->from_date }} s/d {{ $dept->to_date }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Tempat</b></td>
                                            <td>{{ $dept->place }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>Nama Trainer : </b>{{ $dept->user->name }}</td>
                                            <td><b>Dept : </b></td>
                                            <td><b>Posisi :</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <b>Summary Materi Training :</b>
                                                <br>
                                                <p>
                                                    @php
                                                        echo nl2br($dept->summary);
                                                    @endphp
                                                </p>
                                            </td>
                                            <td colspan="3" class="align-top">
                                                <b>Komentar Trainer :</b>
                                                <br>
                                                <p>
                                                    @php
                                                        echo nl2br($dept->comment);
                                                    @endphp
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="border-color: black">
                                            <td colspan="6" class="text-center"
                                                style="background-color: skyblue; border-color:black;">
                                                <b>Penilaian Tingkat Pemahaman</b>
                                            </td>
                                        </tr>
                                        <tr style="border-color: black">
                                            <td style="background-color: skyblue; border-color:black;">No</td>
                                            <td style="background-color: skyblue; border-color:black;">NIK</td>
                                            <td style="background-color: skyblue; border-color:black;">Nama</td>
                                            <td style="background-color: skyblue; border-color:black;">Posisi</td>
                                            <td style="background-color: skyblue; border-color:black;">Tingkat Pemahaman
                                            </td>
                                            <td style="background-color: skyblue; border-color:black;">Komentar Atasan
                                            </td>
                                        </tr>
                                        @foreach ($trAtt as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->nik }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->user->jabatan }}</td>
                                                <td>{{ $item->score }} (1/2/3/4)</td>
                                                <td>{{ $item->ket }} </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td colspan="2"><b>Skor Tingkat Pemahaman Materi:</b></td>
                                        </tr>
                                        <tr>
                                            <td>1. Tidak paham materi yang di ajarkan (< 50%)</td>
                                            <td>2. Hanya paham sebagian materi yang diajarkan (50-69%)</td>
                                        </tr>
                                        <tr>
                                            <td>3. Paham dengan materi yang di ajarkan (70-90%)</td>
                                            <td>4. Paham hampir seluruh materi yang di ajarkan(> 90%)</td>
                                        </tr>
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
    <script src="{{ asset('js/tableToExcel.js') }}"></script>

    <script>
        $("#btn-d").click(function() {
            TableToExcel.convert(document.getElementById("myTablex"), {
                name: "{{ $dept->topic }}.xlsx",
            });
        });
    </script>

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
