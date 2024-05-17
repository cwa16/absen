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
                                <h6 class="text-white text-capitalize ps-3">Attendance Table - Master Shift</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right">
                                    <br>
                                    <br>
                                        <table class="table table-striped table-bordered align-items-center mb-0"
                                            id="table-shift" style="width:100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="text-center">No</th>
                                                    <th>Shift</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Keluar</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no=1;
                                                @endphp
                                                @foreach ($masterShifts as $ms)
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td>{{ $ms->shift }}</td>
                                                    <td>{{ Carbon\Carbon::parse($ms->start_work)->format('H:i:s') }}</td>
                                                    <td>{{ Carbon\Carbon::parse($ms->end_work)->format('H:i:s') }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('shift-master-edit', $ms->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <a href="{{ route('shift-master-delete', $ms->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Tambah Shift Baru</h5>
                        <form action="{{ route('shift-master-add') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="shift" class="form-label">Shift</label>
                                <input type="text" class="form-control" id="shift" name="shift" required>
                            </div>
                            <div class="mb-3">
                                <label for="start_work" class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control" id="start_work" name="start_work" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_work" class="form-label">Jam Keluar</label>
                                <input type="time" class="form-control" id="end_work" name="end_work" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambahkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            @include('admin.includes.footer')
    </div>
    </main>
    @include('admin.includes.script')
    <script>
        $('#table-shift').DataTable();
    </script>
</body>
