@include('admin.includes.head')
<link href="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

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
                                <h6 class="text-white text-capitalize ps-3">Shift Table - Emp with Shift</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%"
                                    style="float: right">
                                <br><br>
                                <table id="shift-setting" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Emp Code</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Dept</th>
                                            <th>Jabatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($empWithShift as $emp)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $emp->nik }}</td>
                                                <td>{{ $emp->name }}</td>
                                                <td>{{ $emp->status }}</td>
                                                <td>{{ $emp->dept }}</td>
                                                <td>{{ $emp->jabatan }}</td>
                                                <td>
                                                    <a href="{{ route('shift-setting-detail',$emp->nik) }}" class="btn btn-primary btn-sm">Shift</a>
                                                    <a href="{{ route('shift-setting-edit',$emp->nik) }}" class="btn btn-warning btn-sm">Edit</a>
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
        @include('admin.includes.footer')
    </main>
    @include('admin.includes.script')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#shift-setting');
    </script>
</body>
