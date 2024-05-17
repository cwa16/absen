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
                                <h6 class="text-white text-capitalize ps-3">Kehadiran Karyawan Per Dept - Filter</h6>
                            </div>
                        </div>
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="card">
                                    <div class="card-header">
                                        <h3><strong>Kehadiran Karyawan Per Dept - Filter</strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <table class="table table-bordered table-data" id="table-data">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 20px;">Tanggal Awal</th>
                                                        <th style="font-size: 20px;">Tanggal Akhir</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <input type="hidden" name="dept" id="" value="{{ $dept }}">
                                                        <td><input type="date" name="start" class="form-control form-select-lg"></td>
                                                        <td><input type="date" name="end" class="form-control form-select-lg"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @if ($dept == 'I/A' || $dept == 'I/B' || $dept == 'I/C' || $dept == 'II/D' || $dept == 'II/E' || $dept == 'II/F' || $dept == 'Factory')
                                                <table class="table table-bordered table-data" style="width: 10%">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkboxAll"></th>
                                                        <th>Mandor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($mandor as $mandor)
                                                    <tr>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="checkboxItem" value="{{ $mandor['nik'] }}" name="mandor[]">
                                                        </td>
                                                        <td>
                                                            <input type="hidden" value="{{ $mandor['nik'] }}">
                                                            {{ $mandor['name'] }}
                                                        </td>
                                                    </tr>
                                                    <tr></tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <table class="table table-bordered table-data" style="width: 10%">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" class="checkboxItem" name ="decision" value="All"></th>
                                                        <th>All Emp</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            @endif
                                            <button class="btn btn-primary btn-lg">Submit</button>
                                        </div>
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
    <script>
        document.getElementById('checkboxAll').addEventListener('click', function () {
            var checkboxes = document.querySelectorAll('.checkboxItem');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = document.getElementById('checkboxAll').checked;
            });
        });

        var checkboxes = document.querySelectorAll('.checkboxItem');
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    var nik = this.value;
                    console.log('NIK:', nik);
                }
            });
        });
    </script>

</body>
