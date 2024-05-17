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
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Periode Bulan</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Shift</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataShiftEmp as $shiftEmp)
                                            <form action="{{ route('shift-setting-update', ['id' => $shiftEmp->id]) }}" method="POST">
                                                @csrf
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="nik" id="nik" value="{{ $nik }}">
                                                        <input type="text" class="form-control" value="{{ Carbon\Carbon::parse($shiftEmp->start_date)->translatedFormat('F Y') }}" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control" value="{{ $shiftEmp->start_date }}" name="start_date" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control" value="{{ $shiftEmp->end_date }}" name="end_date" readonly>
                                                    </td>
                                                    <td>
                                                        <select class="form-select" name="shift">
                                                            <option disabled>Pilih Shift</option>
                                                            @foreach ($masterShifts as $ms)
                                                                <option value="{{ $ms->id }}" @if ($ms->id == $shiftEmp->shift) selected @endif>
                                                                    {{ $ms->shift }} | {{ Carbon\Carbon::parse($ms->start_work)->format('H:i:s') }} | {{ Carbon\Carbon::parse($ms->end_work)->format('H:i:s') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm" type="submit">Edit</button>
                                                    </td>
                                                </tr>
                                            </form>
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
</body>
