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
                                <h6 class="text-white text-capitalize ps-3">Master Employee</h6>
                            </div>
                        </div>

                        <!-- boostrap add and edit book model -->
                        <div class="modal fade" id="ajax-book-model" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="ajaxBookModel"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm"
                                            class="form-horizontal" method="POST">
                                            <input type="hidden" name="id" id="id">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Name</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="names"
                                                        name="names" placeholder="Enter Employee Name" maxlength="50"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Start Work</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" id="start_work"
                                                        name="start_work" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">End Work</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" id="end_work"
                                                        name="end_work" />
                                                </div>
                                            </div>
                                            <div class="col-sm-offset-2 col-sm-10 mt-3">
                                                <button type="submit" class="btn btn-primary" id="btn-save"
                                                    value="addNewBook">Update Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        <!-- boostrap add and edit book model -->
                        <div class="modal fade modal-att" id="ajax-book-model-att" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="ajaxBookModelAtt">End Work Photo Information</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img class="form-control" src="" alt="" id="img-atts">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end bootstrap model -->


                        <div class="card-body">
                            <a href="{{ route('user-master-input') }}" class="btn btn-primary">TAMBAH</a>
                            <div class="table-responsive p-0">
                                <table class="table table-striped table-sm align-items-center mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Emp. Code</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Dept</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Email</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($user as $item)
                                          <tr>
                                            <td>
                                              <a href="{{ route('edit-user', $item->id) }}" class="btn btn-secondary">Ubah</a>
                                            </td>
                                            <td>{{ $item->nik }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->dept }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->role_app }}</td>
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
                ajax: "{{ route('user-master') }}",
                columns: [{
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role_app',
                        name: 'role_app'
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
