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
                                <h6 class="text-white text-capitalize ps-3">Attendance Table - Shift</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right">

                                    <form class="row g-3" method="POST" action="{{ route('search') }}">
                                        @csrf
                                        <div class="col-auto">
                                            <input class="form-control form-control-sm" type="text" name="search_keyword" placeholder="Cari...">
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-sm btn-secondary" type="submit">Cari</button>
                                        </div>
                                    </form>

                                    <form method="POST" action="{{ route('updateShift') }}">
                                        @csrf
                                        <button class="btn btn-primary btn-sm" type="submit">Simpan Perubahan</button>
                                        <div class="form-group row g-3">
                                            <div class="col-auto">
                                                <label>Tanggal :</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="start_date" name="start_date" class="form-control" required>
                                            </div>
                                            <div class="col-auto">
                                                <label> - </label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" id="end_date" name="end_date" class="form-control" required>
                                            </div>
                                        </div>
                                    <br>

                                        <table class="table table-striped table-bordered align-items-center mb-0"
                                            id="table-shift" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Emp Code</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jabatan</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dept</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Shift</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bulan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $currentMonth = null;
                                                @endphp

                                                @foreach ($data as $item => $user )

                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        {{ $item }}
                                                    </td>
                                                </tr>

                                                @foreach ($user as $users)

                                                @php
                                                    $updateTime = $users->updated_at;
                                                    $formattedTime = $updateTime->format('d F Y H:i:s');
                                                    $monthName = $updateTime->format('F');
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="nik[]" value="{{ $users->nik }}">
                                                        {{ $users->nik }}
                                                    </td>
                                                    <td>{{ $users->name }}</td>
                                                    <td>{{ $users->jabatan }}</td>
                                                    <td>{{ $users->dept }}</td>
                                                    <td>{{ $users->status }}</td>
                                                    <td>
                                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="shift[]">
                                                            <option selected disabled>Pilih Shift</option>
                                                            @foreach ($masterShifts as $shift)
                                                                <option value="{{ $shift->id }}" @if($users->shift_code == $shift->id) selected @endif>
                                                                    {{ $shift->shift }} | {{ $shift->start_work->format('H:i:s') }} | {{ $shift->end_work->format('H:i:s') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        @if($users->updated_at)
                                                            <span>
                                                                {{ $monthName }}
                                                            </span>
                                                        @else
                                                            Data belum diperbarui
                                                        @endif
                                                    </td>
                                                </tr>

                                                @endforeach

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
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

</body>
