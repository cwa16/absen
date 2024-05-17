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
                                <h6 class="text-white text-capitalize ps-3">Cuti - {{ Auth::user()->dept }}</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                        <a href="{{ route('list-emp') }}" class="btn btn-primary btn-sm"> Tambah
                                            Baru</a>
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%"
                                            style="float: right">
                                        <table
                                            class="table table-striped table-bordered table-sm table-hover align-items-center mb-0"
                                            id="table-attendance-now" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="11" class="text-center">Data Cuti -
                                                        {{ Auth::user()->dept }} Per
                                                        {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d M Y') }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>NIK</th>
                                                    <th>Name</th>
                                                    <th>Sub Divisi</th>
                                                    <th>Date</th>
                                                    <th>Kind of Leave</th>
                                                    <th>Start Leave</th>
                                                    <th>End Leave</th>
                                                    <th>Total Days</th>
                                                    <th>Purpose</th>
                                                    <th>Person During Leave</th>
                                                    <th>Action</th>
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
                ajax: "{{ route('cuti') }}",
                columns: [{
                        data: 'nik',
                        name: 'user.nik'
                    },
                    {
                        data: 'name',
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
                        data: 'kind',
                        name: 'kind'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'purpose',
                        name: 'purpose'
                    },
                    {
                        data: 'name_sub',
                        name: 'user_subs.name_sub'
                    },
                    {
                        data: 'action',
                        name: 'action'
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
