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
                                <h6 class="text-white text-capitalize ps-3">Attendance Table - Regular</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <!-- boostrap add and edit book model -->
                            <div class="modal fade" id="ajax-book-model-tambah" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="ajaxBookModel">Input Baru Kehadiran</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="javascript:void(0)" id="addEditBookForm"
                                                name="addEditBookForm" class="form-horizontal" method="POST">
                                                <input type="hidden" name="id" id="id">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                class="col-sm-2 control-label">Name</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-control js-data-example-ajax"
                                                                    name="" id="select_2">
                                                                    <option value=""></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="name" class="col-sm-2 control-label">Start
                                                                Work</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="text"
                                                                    id="start_work" name="start_work" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="name"
                                                                class="col-sm-2 control-label">Information</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control"
                                                                    id="names" name="names"
                                                                    placeholder="Enter Information if necessary"
                                                                    maxlength="50" required="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="file" class="form-control"
                                                                id="inputGroupFile02">
                                                            <label class="input-group-text"
                                                                for="inputGroupFile02">Upload</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">End Work</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="text"
                                                                    id="end_work" name="end_work" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-offset-2 col-sm-10 mt-3">
                                                    <button type="submit" class="btn btn-primary" id="btn-save"
                                                        value="addNewBook">Submit
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


                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                      <a href="{{ route('input-manual-reg') }}" class="btn btn-primary btn-sm"> Tambah Baru</a>
                                      <a href="{{ route('absen-regular-import') }}" class="btn btn-success btn-sm"> Import Excel</a>
                                      {{-- Penambahan Ubah TA --}}
                                      <a href="{{ route('change-ta-desc') }}" class="btn btn-warning btn-sm"> Ubah Desc TA</a>
                                      {{-- Penambahan Ubah TA --}}
                                      <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right">
                                        <table class="table table-striped table-bordered align-items-center mb-0"
                                            id="table-attendance-now" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th
                                                        rowspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 align-center text-center">
                                                        NIK</th>
                                                    <th
                                                        rowspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">
                                                        Name</th>
                                                    <th
                                                        rowspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">
                                                        Dept</th>
                                                    <th
                                                        rowspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">
                                                        Date</th>
                                                    <th
                                                        colspan="3" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">
                                                        Start Work</th>
                                                    <th
                                                        colspan="3" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">
                                                        End Work</th>
                                                    <th
                                                        rowspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">
                                                        Information</th>
                                                </tr>
                                                <tr>
                                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">Jam</th>
                                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">Info</th>
                                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">Lampiran  </th>
                                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">Jam</th>
                                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">Info</th>
                                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 align-center text-center">Lampiran  </th>
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
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
    <script src="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js' }}"></script>
    <script>
        $('.js-data-example-ajax').select2({
            ajax: {
                url: 'https://api.github.com/orgs/select2/repos',
                data: function(params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                }
            }
        });
    </script>
    <script>
        $(function() {

            $('*[name=start_work]').appendDtpicker();
            $('*[name=end_work]').appendDtpicker();

        });
    </script>
    <script type="text/javascript">
        $(function() {

            var table = $('#table-attendance-now').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('attendance-reg') }}",
                columns: [{
                        data: 'nik',
                        name: 'user.nik'
                    },
                    {
                        data: 'user',
                        name: 'user.name'
                    },
                    {
                        data: 'dept',
                        name: 'user.dept'
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
                        data: 'start_work_info',
                        name: 'start_work_info'
                    },
                    {
                        data: 'start_work_info_url',
                        name: 'start_work_info_url'
                    },
                    {
                        data: 'end_work',
                        name: 'end_work'
                    },
                    {
                        data: 'end_work_info',
                        name: 'end_work_info'
                    },
                    {
                        data: 'end_work_info_url',
                        name: 'end_work_info_url'
                    },
                    {
                        data: 'desc',
                        name: 'user.desc'
                    },
                ]
            });

            $('body').on('click', '.btn-tambah', function() {
                // Do this before you initialize any of your modals

                $('#ajax-book-model-tambah').modal('show');

            });



        });
    </script>
</body>
