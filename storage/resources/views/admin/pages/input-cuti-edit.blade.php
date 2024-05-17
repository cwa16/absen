@include('admin.includes.head')
<link href="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' }}" rel="stylesheet" />


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
                                <h6 class="text-white text-capitalize ps-3">Input Cuti</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">

                            <div class="card p-0 position-relative mx-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <form action="{{ route('update-cuti') }}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="">Karyawan</label>
                                                        <input type="hidden" name="id" value="{{ $leave->id }}">
                                                        <select name="user_id" id="" class="form-control">
                                                            <option value="{{ $leave->user->id }}">{{ $leave->user->nik }} -
                                                                {{ $leave->user->name }} ({{ $leave->user->jabatan }})</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Pengganti</label>
                                                        <select class="form-control" name="user_sub" id="">
                                                            <option value="{{ $leave->user->id }}" selected>
                                                              {{ $leave->user_subs->nik }} - {{ $leave->user_subs->name }}
                                                            </option>
                                                            @foreach ($emp_sub as $item)
                                                                <option value="{{ $item->id }}">{{ $item->nik }}
                                                                    -
                                                                    {{ $item->name }} ({{ $item->jabatan }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <label for="">Mulai Cuti</label>
                                                        <input class="form-control" type="date" name="from"
                                                            id="from">
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Selesai Cuti</label>
                                                        <input class="form-control" type="date" name="to"
                                                            id="to">
                                                    </div>

                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="tes">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Akhir Pekan
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Hari Libur</label>
                                                        <input type="number" name="" id="dayoff"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Jumlah Hari</label>
                                                        <input class="form-control" type="text" id="days"
                                                            name="days" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label for="">Jenis Cuti</label>
                                                        <select name="kind" id="" class="form-control">
                                                            <option value="" selected disabled>-- Pilih Jenis Cuti
                                                                --</option>
                                                            <option value="Large">Besar</option>
                                                            <option value="Yearly">Tahunan</option>
                                                            <option value="Birth">Nikah</option>
                                                            <option value="Sick">Sakit</option>
                                                            <option value="Other">Lain-lain</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <label for="">Keterangan Cuti</label>
                                                        <input type="text" class="form-control" name="purpose" value="{{ $leave->purpose }}">
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <button class="btn btn-primary">UPDATE</button>
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
                                                        @forelse ($b_leave as $item)
                                                            <tr>
                                                                <th>Besar</th>
                                                                <th>{{ $item->large }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Tahunan</th>
                                                                <th>{{ $item->yearly }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Nikah</th>
                                                                <th>{{ $item->birth }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Sakit</th>
                                                                <th>{{ $item->sick }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Lain-lain</th>
                                                                <th>{{ $item->other }}</th>
                                                            </tr>
                                                        @empty
                                                            <li>Data Cuti Kosong</li>
                                                        @endforelse
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
        $('body').on('change', '#to', function() {
            // Do this before you initialize any of your modals

            var start = $('#from').val();
            var end = $('#to').val();

            // end - start returns difference in milliseconds 
            var diff = new Date(Date.parse(end) - Date.parse(start));

            // get days
            var days = diff / 1000 / 60 / 60 / 24;

            $('#days').val(days);

        });
    </script>
    <script>
        $("#tes").change(function() {
            var dayString = $('#days').val();
            var days = parseInt(dayString);

            if ($(this).prop('checked')) {
                var weekend = days-2;
                $('#days').val(weekend);
            } else {
                var weekenda = days+2;
                $('#days').val(weekenda);
            }
        });
        
        $("#dayoff").change(function() {
            var dayString = $('#days').val();
            var days = parseInt(dayString);
            var dayoffString = $('#dayoff').val();
            var dayoff = parseInt(dayoffString);
            var dayoffT = days-dayoff;
            $('#days').val(dayoffT);
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
