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
                                <h6 class="text-white text-capitalize ps-3">Input - Budget Cuti</h6>
                            </div>
                        </div>

                        <div class="card-body">
                          <form action="{{ route('store-budget-cuti') }}" method="post">
                            @csrf
                            <button class="btn btn-primary">Submit</button>
                            <input type="date" name="dates" id="date"
                                    class="form-control form-control-sm date" required>
                            <div class="table-responsive p-0">
                                
                                <table class="table table-striped table-sm align-items-center mb-0" id=""
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Emp. Code</th>
                                            <th rowspan="2"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama</th>
                                            <th rowspan="2"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jabatan</th>
                                            <th rowspan="2"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Dept.</th>
                                            <th colspan="5"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Cuti</th>

                                        </tr>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Large</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Yearly</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Birth</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Sick</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Other</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $item)
                                            <tr>
                                                <td><input type="text" name="user_id[]"
                                                        value="{{ $item->nik }}" readonly>
                                                        <input class="datex" type="hidden" name="date[]" id="datex"></td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->jabatan }}</td>
                                                <td>{{ $item->dept }}</td>
                                                <td><input class="form-control form-control-sm" type="text"
                                                        name="large[]" id="" value="" required></td>
                                                <td><input class="form-control form-control-sm" type="text"
                                                        name="yearly[]" id="" value="" required></td>
                                                <td><input class="form-control form-control-sm" type="text"
                                                        name="birth[]" id="" value="" required></td>
                                                <td><input class="form-control form-control-sm" type="text"
                                                        name="sick[]" id="" value="" required></td>
                                                <td><input class="form-control form-control-sm" type="text"
                                                        name="other[]" id="" value="" required></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <tfoot class="mt-3"> {{ $user->withQueryString()->links() }}</tfoot>
                            </div>
                          </form>
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

    <script>
        $('body').on('change', '.date', function() {

            var datex = $('.datex');
            var date = $('.date').val();
            datex.val(date);
        })
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
