@include('sweetalert::alert')
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
                                <form method="POST" action="{{ route('update-new') }}">
                                    @csrf
                                    <button type="submit">Update Data</button>
                                </form>
                                <form method="POST" action="{{ route('update-desc') }}">
                                    @csrf
                                    <button type="submit">Update Desc</button>
                                </form>
                                <form method="POST" action="{{ route('testing-update-shift-3') }}">
                                    @csrf
                                    <button type="submit">Update Data Shift 3</button>
                                </form>
                                <form method="POST" action="{{ route('att-log-archive') }}">
                                    @csrf
                                    <button type="submit">Archive Att Log Data</button>
                                </form>
                                <form method="POST" action="{{ route('absen-regs-archive') }}">
                                    @csrf
                                    <button type="submit">Archive Absen Regs Data</button>
                                </form>
                                <form action="{{ route('export-sequel') }}" method="post">
                                    @csrf
                                    <input type="date" name="start" id="">
                                    <input type="date" name="end" id="">
                                    <button>Export to SQL</button>
                                </form>
                                <form action="{{ route('del-att-data') }}" method="post">
                                    @csrf
                                    <input type="date" name="start_del" id="">
                                    <input type="date" name="end_del" id="">
                                    <button>Delete Data</button>
                                </form>
                                <form action="{{ route('testing-update-calc') }}" method="post">
                                    @csrf
                                    <input type="date" name="start" id="">
                                    <input type="date" name="end" id="">
                                    <select name="actions" id="">
                                        <option value="HO">HO</option>
                                        <option value="WS">Workshop</option>
                                    </select>
                                    <button>Calculate Non Shift Data</button>
                                </form>
                                <form action="{{ route('testing-update-calc-shift') }}" method="post">
                                    @csrf
                                    <input type="date" name="start" id="">
                                    <input type="date" name="end" id="">

                                    <button>Calculate Shift Data</button>
                                </form>
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

