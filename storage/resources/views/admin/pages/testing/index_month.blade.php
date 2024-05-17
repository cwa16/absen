@include('admin.includes.head')
    <body class="g-sidenav-show bg-gray-200">
        @include('admin.layouts.sidenav')
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" >
        @include('admin.layouts.navbar')
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h4 class="text-white text-capitalize ps-3 font-weight-bold">Attendance Table - Summary (All)</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <form method="POST" action="{{ route('testing-update') }}">
                                    @csrf
                                    <button type="submit">Update Data</button>
                                </form>
                                <form action="{{ route('testing-update-calc') }}" method="post">
                                    @csrf
                                    <input type="date" name="start" id="">
                                    <input type="date" name="end" id="">
                                    <button>Calculate Non Shift Data</button>
                                </form>
                                <form action="{{ route('testing-update-calc-shift') }}" method="post">
                                    @csrf
                                    <input type="date" name="start" id="">
                                    <input type="date" name="end" id="">
                                    <button>Calculate Shift Data</button>
                                </form>
                                    <table class="table table-striped table-bordered hover" id="month-detail" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Emp Code</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Dept</th>
                                                <th>Jabatan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <thead class="bg-dark text-light">
                                            <tr>
                                                <th>Emp Code</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Dept</th>
                                                <th>Jabatan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data as $emp)
                                            <tr>
                                                <td>{{ $emp->nik }}</td>
                                                <td>{{ $emp->name }}</td>
                                                <td>{{ $emp->status }}</td>
                                                <td>{{ $emp->dept }}</td>
                                                <td>{{ $emp->jabatan }}</td>
                                                <td>
                                                    <a href="{{ route('view-summary-emp-testing-month',$emp->nik) }}" class="btn btn-primary btn-sm" style="margin-bottom: -1px;">VIEW</a>
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
                @include('admin.includes.footer')
            </div>
        </main>
        @include('admin.includes.script')

        <script>
            $('#month-detail').DataTable({
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

