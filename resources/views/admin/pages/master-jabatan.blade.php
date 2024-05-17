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
                                <h6 class="text-white text-capitalize ps-3">Master Jabatan</h6>
                            </div>
                        </div>

                      <div class="card-body">
                        <form action="{{ route('store-jabatan') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" name="jabatan" id="" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label for="singkatan">Singkatan</label>
                                    <input type="text" name="alias" id="" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label for="">Aksi</label>
                                    <button class="btn btn-primary btn-sm form-control">Simpan</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col">
                                <table class="table table-bordered table-sm table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Jabatan</th>
                                            <th>Singkatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->jabatan }}</td>
                                                <td>{{ $item->alias }}</td>
                                                <td>
                                                    <a href="{{ route('delete-jabatan', $item->id) }}">Hapus</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">No data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
    <script>
            $('.activeCheckbox').change(function() {
                var isChecked = $(this).prop('checked');
                var nik = $(this).data('item-id');
                $.ajax({
                    type: "POST",
                    url: "{{ route('update-active') }}",
                    data: {
                        nik: nik,
                        isChecked: isChecked,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
    </script>
    <script type="text/javascript">
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
                        $('#row_' + id).remove();
                    }
                });
            }
        }
    </script>
</body>
