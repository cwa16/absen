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
                                    <form method="POST" action="{{ route('shift-master-update', $shift->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="shift_code">Shift Code</label>
                                            <input type="text" name="shift_code" id="shift_code" class="form-control" value="{{ $shift->shift_code }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="shift">Shift</label>
                                            <input type="text" name="shift" id="shift" class="form-control" value="{{ $shift->shift }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="start_work">Jam Masuk</label>
                                            <input type="time" name="start_work" id="start_work" class="form-control" value="{{ $shift->start_work->format('H:i') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="end_work">Jam Keluar</label>
                                            <input type="time" name="end_work" id="end_work" class="form-control" value="{{ $shift->end_work->format('H:i') }}" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
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
</body>
