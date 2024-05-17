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
                                <h6 class="text-white text-capitalize ps-3">Ubah data kehadiran</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">

                            <div class="card">
                                <div class="card-body">
                                    <h1>Cari karyawan</h1>

                                    <form action="{{ route('attendance-input-ubah-new') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <select name="nik" id="name" class="form-control name">
                                                    @foreach ($users as $item)
                                                        <option value="{{ $item->nik }}">{{ $item->nik }} - {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="date" name="date1" id="" class="form-control">
                                            </div>
                                            <div class="col">
                                                <input type="date" name="date2" id="" class="form-control">
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-primary">Cari</button>
                                            </div>
                                        </div>


                                    </form>
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
    <script>
        new DataTable('#table-attendance-now');
    </script>
    <script src="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js' }}"></script>
    <script>
        $(document).ready(function() {
            $('.name').select2();
        });
    </script>
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
    {{-- <script type="text/javascript">
        $(function() {

            var table = $('#table-attendance-now').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('attendance-now') }}",
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
    </script> --}}
</body>
