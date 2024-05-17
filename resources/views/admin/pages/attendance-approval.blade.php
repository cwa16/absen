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
                                <h6 class="text-white text-capitalize ps-3">Attendance Table - Approval</h6>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <form action="{{ route('update-approve-batch') }}" method="post">
                                    @csrf
                                    <input type="hidden" class="idc" name="idc" id="idc" value="">
                                    <button class="btn btn-primary">Approve Selected</button>
                                </form>
                            </div>
                            <div class="col">
                                <div class="text-right" style="text-align: right">
                                    <form action="{{ route('update-unapprove-batch') }}" method="post">
                                        @csrf
                                        <input type="hidden" class="idc" name="idc" id="idc" value="">
                                        <button class="btn btn-danger">Unapprove Selected</button>
                                    </form>
                                </div>
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
                                                    <input type="text" class="form-control" id="names" name="names"
                                                        placeholder="Enter Employee Name" maxlength="50" required="">
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

                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table class="table table-striped table-sm align-items-center mb-0"
                                    id="table-attendance-now" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                NIK</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Dept</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Date</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Start Work</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                End Work</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Approval</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Approval By</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Action</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                <input type="checkbox" name="" id="">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
        // $(document).ready(function() {
        //     $("#save_value").click(function() {
        //         var favProgramming = [];
        //         $.each($("input[name='check-manager']:checked"), function() {
        //             favProgramming.push($(this).val());
        //         });

        //         $('#idc').val(favProgramming);
        //     });
        // });
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
                ajax: "{{ route('attendance-approval') }}",
                columns: [
                    {
                        data: 'nik',
                        name: 'nik.nik'
                    },
                    {
                        data: 'name',
                        name: 'name.name'
                    },
                    {
                        data: 'dept',
                        name: 'dept.dept'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'start_work',
                        name: 'start_work'
                    },
                    {
                        data: 'end_work',
                        name: 'end_work'
                    },
                    {
                        data: 'approval',
                        name: 'approval'
                    },
                    {
                        data: 'approval_by',
                        name: 'approval_by'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'check',
                        name: 'check'
                    }
                ]
            });

            $('body').on('change', '.check-manager', function() {
                var favProgramming = [];
                $.each($("input[name='check-manager']:checked"), function() {
                    favProgramming.push($(this).val());
                });

                $('.idc').val(favProgramming);
            });

            $('body').on('click', '.edit-hrd', function() {
                var id = $(this).data('id');

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('edit-hrd') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#ajaxBookModel').html("Edit Attendance");
                        $('#ajax-book-model').modal('show');
                        $('#id').val(res.id);
                        $('#names').val(res.user.name);
                        $('#start_work').val(res.start_work);
                        $('#end_work').val(res.end_work);
                    }
                });
            });

            $('body').on('click', '#btn-save', function(event) {
                var id = $("#id").val();
                var start_work = $("#start_work").val();
                var end_work = $("#end_work").val();
                $("#btn-save").html('Please Wait...');
                $("#btn-save").attr("disabled", true);

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('update-att') }}",
                    data: {
                        id: id,
                        start_work: start_work,
                        end_work: end_work
                    },
                    dataType: 'json',
                    success: function(res) {
                        $("#ajax-book-model").modal('hide');
                        var oTable = $('#table-attendance-now').dataTable();
                        oTable.fnDraw(false);
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    }
                });
            });

        });
    </script>
</body>
