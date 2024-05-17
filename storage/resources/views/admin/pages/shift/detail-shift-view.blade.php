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
                                <h4 class="text-white text-capitalize ps-3 font-weight-bold">Detail Shift Table</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="table-detal-shift" style="width:100%">
                                    <thead>
                                        <tr>
                                            <td>Emp Code</td>
                                            <td>Name</td>
                                            <td>Status</td>
                                            <td>Dept</td>
                                            <td>Jabatan</td>
                                            <td>Action</td>
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
                                        @foreach ($data as $item => $user )
                                            @foreach ($user as $users)
                                            <tr>
                                                <td>{{ $users->nik }}</td>
                                                <td>{{ $users->name }}</td>
                                                <td>{{ $users->status }}</td>
                                                <td>{{ $users->dept }}</td>
                                                <td>{{ $users->jabatan }}</td>
                                                <td class="text-center">
                                                    <a href={{ route('shift-new-detail',$users->nik) }} class="btn btn-primary btn-sm">Detail</a>
                                                </td>
                                            </tr>
                                            @endforeach
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
        $('#table-detal-shift').DataTable({
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

