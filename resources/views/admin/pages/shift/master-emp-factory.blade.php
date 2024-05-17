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
                                <h6 class="text-white text-capitalize ps-3">Attendance Table - Master Shift</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%"
                                            style="float: right">
                                        <br>
                                        <form method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-label">Filter Dept</label>
                                                    <select class="form-select" name="selected_status"
                                                        id="selected_status">
                                                        <option selected disabled>Pilih Dept</option>
                                                        @foreach ($uniqueStatus as $status)
                                                            <option value="{{ $status }}">{{ $status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="">Status</label>
                                                    <select class="form-select mb-2" name="dept" id="dept">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <button formaction="{{ route('filter-data-emp') }}" type="submit" class="btn btn-primary mt-4">Filter</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" class="form-control" name="cari_emp">
                                                </div>
                                                <div class="col">
                                                    <button formaction="{{ route('search-data-emp') }}" class="btn btn-primary">Cari</button>
                                                </div>
                                            </div>


                                        </form>

                                        <form method="POST" action="{{ route('updateShift') }}">
                                            @csrf

                                            <button class="btn btn-primary btn-sm" type="submit">Simpan
                                                Perubahan</button>

                                            <div class="form-group row g-3">
                                                <div class="col-auto">
                                                    <label>Tanggal :</label>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="date" id="start_date" name="start_date"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col-auto">
                                                    <label> - </label>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="date" id="end_date" name="end_date"
                                                        class="form-control" required>
                                                </div>
                                            </div>

                                            <br>

                                            @if (isset($filteredData) && count($filteredData) > 0)
                                                <table
                                                    class="table table-striped table-bordered align-items-center mb-0"
                                                    id="table-shift" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-center">
                                                                <input type="checkbox" id="checkAll"></th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Emp Code</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Name</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Jabatan</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Dept</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Status</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Shift</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($filteredData as $data)
                                                            <tr>
                                                                <td class="text-center"><input type="checkbox" name="selected_ids[]" class="checkBoxClass" value="{{ $data->nik }}"></td>
                                                                <td>
                                                                    <input type="hidden" name="nik[]"
                                                                        value="{{ $data->nik }}">
                                                                    {{ $data->nik }}
                                                                </td>
                                                                <td>{{ $data->name }}</td>
                                                                <td>{{ $data->jabatan }}</td>
                                                                <td>{{ $data->dept }}</td>
                                                                <td>{{ $data->status }}</td>
                                                                <td>
                                                                    <select class="form-select form-select-sm"
                                                                        aria-label=".form-select-sm example"
                                                                        name="shift[]">
                                                                        <option selected disabled>Pilih Shift</option>
                                                                        @foreach ($masterShifts as $shift)
                                                                            <option value="{{ $shift->id }}">
                                                                                {{ $shift->shift }} |
                                                                                {{ $shift->start_work->format('H:i:s') }}
                                                                                |
                                                                                {{ $shift->end_work->format('H:i:s') }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p>Tidak ada data yang cocok.</p>
                                            @endif
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
    <script>
        document.getElementById("checkAll").addEventListener("change", function() {
            var checkboxes = document.getElementsByClassName("checkBoxClass");
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#selected_status').click(function() {
                $.ajax({
                    url: '{{ route('filter-position') }}',
                    method: 'POST',
                    data: {
                        selected_status: $(this).val()
                    },
                    success: function(response) {
                        $('#dept').empty();

                        $.each(response, function(data, data) {
                            $('#dept').append(new Option(data, data))
                        })
                    }
                });
            });
        });
    </script>
</body>
