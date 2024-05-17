@include('admin.includes.head')

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
                                <h6 class="text-white text-capitalize ps-3">Shift Table - Master Shift</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%"
                                    style="float: right">
                                <br><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>NIK: {{ $dataEmp->nik }}</h5>
                                        <h5>Nama: {{ $dataEmp->name }}</h5>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <h5>Dept: {{ $dataEmp->dept }}</h5>
                                    </div>
                                </div>
                                <form action="{{ route('shift-setting-add') }}" method="POST">
                                    @csrf
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Berlaku</th>
                                                <th>Tanggal Berakhir</th>
                                                <th>Shift</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="nik" id="nik" value="{{ $nik }}">
                                                    <input class="form-control" type="date" name="start_date" id="">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="date" name="end_date" id="">
                                                </td>
                                                <td>
                                                    <select class="form-select" aria-label="Default select example" name="shift">
                                                        <option selected disabled>Pilih Shift</option>
                                                        @foreach ($masterShifts as $ms)
                                                            <option value="{{ $ms->id }}">{{ $ms->shift }} | {{ Carbon\Carbon::parse($ms->start_work)->format('H:i:s') }} | {{ Carbon\Carbon::parse($ms->end_work)->format('H:i:s') }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.includes.footer')
    </main>
    @include('admin.includes.script')
</body>
