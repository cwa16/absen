@include('admin.includes.head')

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
                                <h6 class="text-white text-capitalize ps-3">Master Absensi</h6>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table class="table table-striped table-bordered table-sm align-items-center mb-0"
                                    id="table-attendance-now" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Date</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Dept</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($master_absen as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>
                                                    {{ Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                                                </td>
                                                <td>
                                                    {{ $item->dept }}
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <form action="{{ route('master-absen-view') }}" method="POST">
                                                            <input type="hidden" name="date"
                                                                value="{{ $item->date }}">
                                                            <input type="hidden" name="dept"
                                                                value="{{ $item->dept }}">
                                                            <button class="btn btn-primary btn-sm"
                                                                style="margin-bottom: -15px;">View</button>
                                                        </form>
                                                        <form action="{{ route('master-absen-delete') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="date"
                                                                value="{{ $item->date }}">
                                                            <input type="hidden" name="dept"
                                                                value="{{ $item->dept }}">
                                                            <button class="btn btn-danger btn-sm"
                                                                style="margin-bottom: -15px;">Delete</button>
                                                        </form>
                                                    </div>
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
        $(document).ready(function() {
            $('#table-attendance-now').DataTable();
        });
    </script>
    <script>
        $(function() {

            $('*[name=start_work]').appendDtpicker();
            $('*[name=end_work]').appendDtpicker();

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    function deleteFunc(id) {
                        if (confirm("Delete Record?") == true) {
                            var id = id;
                            // ajax
                            $.ajax({
                                type: "POST",
                                url: "{{ route('delete-emp') }}",
                                data: {
                                    id: id
                                },
                                dataType: 'json',
                                success: function(res) {
                                    var oTable = $('#table-attendance-now').dataTable();
                                    oTable.fnDraw(false);
                                }
                            });
                        }
                    }
    </script>


</body>
