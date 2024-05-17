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
                                <h6 class="text-white text-capitalize ps-3">Attendance Table - Shift Detail</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right">
                                    <br>
                                    <form method="POST" action="{{ route('filter-data') }}">
                                        @csrf
                                        <label for="filterMonth" class="form-label">Filter Bulan</label>
                                        <div class="">
                                            <div class="row">
                                                <div class="col-11">
                                                    <select class="form-select" id="filterMonth" name="filterMonth">
                                                        <option selected disabled>Pilih Bulan</option>
                                                        @foreach ($monthsAndYears as $value => $label)
                                                        <option value="{{ $value }}">{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    @if(isset($filteredData) && count($filteredData) > 0)
                                        <table class="table table-striped table-bordered align-items-center" id="detail-shift" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Emp Code</th>
                                                    <th>Nama</th>
                                                    <th>Dept</th>
                                                    <th>Jabatan</th>
                                                    <th>Status</th>
                                                    <th>Shift</th>
                                                    <th>Jam Kerja</th>
                                                    <th>Tanggal Shift</th>
                                                </tr>
                                            </thead>
                                            <thead class="bg-dark text-light">
                                                <tr>
                                                    <th>Emp Code</th>
                                                    <th>Nama</th>
                                                    <th>Dept</th>
                                                    <th>Jabatan</th>
                                                    <th>Status</th>
                                                    <th>Shift</th>
                                                    <th>Jam Kerja</th>
                                                    <th>Tanggal Shift</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($filteredData as $data)
                                                <tr>
                                                    <td>{{ $data->nik }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->dept }}</td>
                                                    <td>{{ $data->jabatan }}</td>
                                                    <td>{{ $data->status }}</td>
                                                    <td>{{ $data->shift }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->start_work)->format('H:i') }} - {{ \Carbon\Carbon::parse($data->end_work)->format('H:i') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->start_date)->format('d') }} - {{ \Carbon\Carbon::parse($data->end_date)->format('d M y') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                            <p>Tidak ada data yang cocok dengan bulan yang dipilih.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @include('admin.includes.footer')
    </main>
    @include('admin.includes.script')
    <script>
        $('#detail-shift').DataTable({
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;

                        // Create select element and listener
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.header()).empty())
                            .on('change', function () {
                                var val = DataTable.util.escapeRegex($(this).val());

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        // Add list of options
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + '</option>'
                                );
                            });
                    });
            }
        });
    </script>
</body>
