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
                                <h6 class="text-white text-capitalize ps-3">Kehadiran Per Dept Filter Print</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%"
                                            style="float: right">
                                        <br>
                                        <form action="{{ route('summary-per-dept-pdf') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label">Filter Dept</label>
                                                    <select class="form-select" name="dept"
                                                        id="dept">
                                                        <option selected disabled>Select Dept</option>
                                                        @if ($userDept == 'HR Legal' ||$userDept == 'BSKP')
                                                            @foreach ($getEmployeesDept as $dept)
                                                                <option value="{{ $dept }}">{{ $dept }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="{{ $userDept }}" selected>{{ $userDept }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                {{-- <div class="col">
                                                    <label for="">Status</label>
                                                    <select class="form-select mb-2" name="status" id="status">
                                                        <option selected disabled>Select Status</option>
                                                        @foreach ($getEmployeesStatus as $status)
                                                        <option value="{{ $status }}">{{ $status }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}
                                                <div class="col">
                                                    <label for="">Year</label>
                                                    <select class="form-select mb-2" name="year" id="year">
                                                        <option selected disabled>Select Year</option>
                                                        @foreach ($yearValue as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="">Month</label>
                                                    <select class="form-select mb-2" name="month" id="month">
                                                        <option selected disabled>Select Month</option>
                                                        @foreach ($month as $index => $m)
                                                        <option value="{{ $index + 1 }}">{{ $m }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" class="btn btn-danger mt-4">PDF</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
