@include('admin.includes.head')
{{-- <link rel="stylesheet" href="{{ ('https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css') }}"> --}}

<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('sweetalert::alert')
        @include('admin.layouts.navbar')
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h2 class="text-white text-capitalize ps-3">Master Training Data</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ route('chooseDept') }}" class="btn btn-primary btn-sm">Tambah Data</a>
                                    <a href="{{ route('master-training-emp') }}" class="btn btn-primary btn-sm">Data Per
                                        Karyawan</a>
                                    <a href="{{ route('summary-actual-training') }}" class="btn btn-primary btn-sm">Summary Actual Training</a>
                                    <a href="{{ route('data-detail-training') }}" class="btn btn-primary btn-sm">Detail Data Training</a>
                                    <a href="{{ route('training-import') }}" class="btn btn-primary btn-sm">Import Data Training</a>
                                    <div class="table" style="overflow: auto;">
                                        <table
                                            class="table table-bordered table-striped table-hover table-sm"
                                            id="table-data">
                                            <thead>
                                                <tr class="text-center" style="background-color: orange;">
                                                    <th>No</th>
                                                    <th>Kind</th>
                                                    <th>Topic</th>
                                                    <th>Trainer</th>
                                                    <th>From</th>
                                                    <th>Participants</th>
                                                    <th>Place</th>
                                                    <th>Category</th>
                                                    <th>Print</th>
                                                    <th>Edit</th>
                                                    <th>View</th>
                                                    <th>Delete</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                    <tr class="align-middle">
                                                        <td>{{ $item->no }}</td>
                                                        <td>{{ $item->kind }}</td>
                                                        <td>{{ $item->topic }}</td>
                                                        <td>{{ $item->trainer_name }}</td>
                                                        <td>{{ $item->from_date}}
                                                        </td>
                                                        <td>{{ $item->att }}</td>
                                                        <td>{{ $item->place }}</td>
                                                        <td>{{ $item->category }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('print-training', $item->id_data) }}"
                                                                class="btn btn-warning"><i
                                                                    class="fa-solid fa-print"></i></a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('edit-training', $item->id_data) }}"
                                                                class="btn btn-secondary"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('detail-training', $item->id_data) }}"
                                                                class="btn btn-primary"><i
                                                                    class="fa-solid fa-eye"></i></a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('delete-training', $item->id_data) }}"
                                                                class="btn btn-danger"><i
                                                                    class="fa-solid fa-trash"></i></a>
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
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
    {{-- <script src="{{ ('https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('#table-data').DataTable();
        });
    </script>
    <script>
        $(function() {
            $('.check_id').change(function() {
                if ($(this).is(':checked')) {
                    var favProgramming = [];
                    $.each($("input[name='check_id']:checked"), function() {
                        favProgramming.push($(this).val());
                    });
                    $('#id_check').val(favProgramming);
                }
            });
        });
    </script>
    <script type="text/javascript">

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
