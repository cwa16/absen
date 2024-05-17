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
                                <h6 class="text-white text-capitalize ps-3">Budget Cuti</h6>
                            </div>
                        </div>

                        <div class="card-body">
                            <a href="{{ route('budget-cuti-new') }}" class="btn btn-primary">Tambah Budget</a>
                            <form action="{{ route('import-excel-budget-cuti') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <label>Pilih file excel</label>
                                <div class="form-group">
                                    <input class="form-control" type="file" name="file" required="required">

                                    <button class="btn btn-success mt-3" type="submit" id="btn-import">Import</button>
                                </div>
                            </form>
                            <div class="container">
                                <form action="{{ route('budget-cuti-search') }}" method="POST" role="search">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Search users"> <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-striped table-bordered table-sm align-items-center mb-0"
                                    id="" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Emp. Code</th>
                                            <th rowspan="2"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                            <th rowspan="2"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jabatan</th>
                                            <th rowspan="2"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Dept.</th>
                                            <th colspan="5"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Cuti {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('Y') }}
                                            </th>
                                            <th rowspan="2"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Large</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Yaerly</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Birth</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Sick</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Other</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            @foreach ($item->leave_budget as $itemx)
                                                <tr>
                                                    <td>{{ $item->nik }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->jabatan }}</td>
                                                    <td>{{ $item->dept }}</td>
                                                    <td><input type="text" value="{{ $itemx->large }}" class="form-control form-control-sm large" disabled></td>
                                                    <td><input type="text" value="{{ $itemx->yearly }}" class="form-control form-control-sm yearly" disabled></td>
                                                    <td><input type="text" value="{{ $itemx->birth }}" class="form-control form-control-sm birth" disabled></td>
                                                    <td><input type="text" value="{{ $itemx->sick }}" class="form-control form-control-sm sick" disabled></td>
                                                    <td><input type="text" value="{{ $itemx->other }}" class="form-control form-control-sm other" disabled></td></td>
                                                    <td>
                                                        <a href="#" class="btn btn-secondary btn-sm edit-btn">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                <tfoot class="mt-3"> {{ $data->withQueryString()->links() }}</tfoot>
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
        $('.edit-btn').on('click', function() {
            $('.large').removeAttr('disabled');
            $('.yearly').removeAttr('disabled');
            $('.birth').removeAttr('disabled');
            $('.sick').removeAttr('disabled');
            $('.other').removeAttr('disabled');
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
            var table = $('#table-attendance-now').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('budget-cuti') }}",
                columns: [{
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },

                ]
            });
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
