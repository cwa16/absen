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
                                <h6 class="text-white text-capitalize ps-3">Input Cuti</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">

                            <div class="card p-0 position-relative mx-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <form action="{{ route('store-cuti') }}" method="post">
                                                @csrf

                                                <div class="row">
                                                    <div class="col">
                                                        <label for="">Karyawan</label>
                                                        <input type="hidden" name="leave_balance" value="{{ $cuti_tahunan }}">
                                                        <select name="user_id" id="" class="form-control">
                                                            @foreach ($emp as $item)
                                                                <option value="{{ $item->nik }}">{{ $item->nik }}
                                                                    -
                                                                    {{ $item->name }} ({{ $item->jabatan }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Pengganti</label>
                                                        <select class="form-control select2" name="user_sub"
                                                            id="" required>
                                                            <option value="" selected disabled>-- Pilih Karyawan
                                                                --
                                                            </option>
                                                            @foreach ($emp_sub as $item)
                                                                <option value="{{ $item->nik }}">{{ $item->nik }}
                                                                    -
                                                                    {{ $item->name }} ({{ $item->jabatan }} -
                                                                    {{ $item->dept }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <label for="">Mulai Cuti</label>
                                                        <input class="form-control" type="date" name="from"
                                                            id="from" required>
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Selesai Cuti</label>
                                                        <input class="form-control" type="date" name="to"
                                                            id="to" required>
                                                    </div>

                                                    <div class="col">
                                                        <label for="">Masuk Kerja</label>
                                                        <input class="form-control" type="date" name="return"
                                                            id="return_date" required>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col">
                                                        @if (
                                                            ($empS != 'Factory' &&
                                                                $empS != 'FSD' &&
                                                                $empS != 'Workshop' &&
                                                                $empS != 'I/A' &&
                                                                $empS != 'I/B' &&
                                                                $empS != 'I/C' &&
                                                                $empS != 'II/D' &&
                                                                $empS != 'II/E' &&
                                                                $empS != 'II/F' &&
                                                                $empS != 'Security') ||
                                                                $empJ == 'Driver')
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="tes">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    Akhir Pekan (Sabtu) for Office
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Hari Libur</label>
                                                        <input type="number" name="" id="dayoff"
                                                            class="form-control" value="{{ $check }}" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Jumlah Hari</label>
                                                        <input class="form-control" type="text" id="days"
                                                            name="days" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Jenis Cuti</label>
                                                        <select name="kind" id="" class="form-control"
                                                            required>
                                                            <option value="" selected disabled>-- Pilih Jenis Cuti
                                                                --</option>
                                                            <option value="Large">Besar</option>
                                                            <option value="Yearly">Tahunan</option>
                                                            <option value="Birth">Melahirkan</option>
                                                            <option value="Sick">Sakit</option>
                                                            <option value="Other">Lain-lain</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <label for="">Keterangan Cuti</label>
                                                        <input type="text" class="form-control" name="purpose"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="text-center">Saldo Cuti</h6>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-striped table-sm">
                                                        <tr>
                                                            <td>Cuti Besar</td>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cuti Tahunan</td>
                                                            <td>{{ $cuti_tahunan }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cuti Melahirkan</td>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cuti Sakit</td>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cuti Lain-lain</td>
                                                            <td>
                                                            </td>
                                                        </tr>
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
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
    <script src="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js' }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#to').change(function(e) {
            e.preventDefault();

            var from = $('input[name=from]').val();
            var to = $('input[name=to]').val();

            $.ajax({
                type: 'POST',
                url: "{{ route('check-holiday') }}",
                data: {
                    from: from,
                    to: to
                },
                success: function(data) {
                    $('#dayoff').val(data.success);
                    var dayoffString = $('#dayoff').val();
                    var dayString = $('#days').val();
                    var days = parseInt(dayString);
                    var dayoff = parseInt(dayoffString);
                    var dayoffT = days - dayoff;
                    $('#days').val(dayoffT);
                }
            });


        });
    </script>
    <script>
        $('body').on('change', '#to', function() {
            // Do this before you initialize any of your modals

            var start = $('#from').val();
            var end = $('#to').val();

            // end - start returns difference in milliseconds
            var diff = new Date(Date.parse(end) - Date.parse(start));

            // get days
            var days = diff / 1000 / 60 / 60 / 24;

            $('#days').val(days + 1);

        });
    </script>
    <script>
        $("#tes").change(function() {
            var dayString = $('#days').val();
            var days = parseInt(dayString);

            if ($(this).prop('checked')) {
                if (days >= 12) {
                    var weekend = days - 2;
                    $('#days').val(weekend);
                } else {
                    var weekend = days - 1;
                    $('#days').val(weekend);
                }

            } else {
                var weekenda = days + 1;
                $('#days').val(weekenda);
            }
        });

        $("#tes2").change(function() {
            var dayString = $('#days').val();
            var days = parseInt(dayString);

            if ($(this).prop('checked')) {
                var weekend = days - 1;
                $('#days').val(weekend);
            } else {
                var weekenda = days + 1;
                $('#days').val(weekenda);
            }
        });
    </script>
    <script>
        $(function() {

            $('*[name=start_work]').appendDtpicker();
            $('*[name=end_work]').appendDtpicker();

        });
    </script>
    <script type="text/javascript">
        $(function() {

            var table = $('#table-attendance-now').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('cuti') }}",
                columns: [{
                        data: 'nik',
                        name: 'user.nik'
                    },
                    {
                        data: 'name',
                        name: 'user.name'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'purpose',
                        name: 'purpose'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });

            $('body').on('click', '.btn-tambah', function() {
                // Do this before you initialize any of your modals

                $('#ajax-book-model-tambah').modal('show');

            });



        });
    </script>
</body>
