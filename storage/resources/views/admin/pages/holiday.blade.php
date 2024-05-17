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
                                <h6 class="text-white text-capitalize ps-3">Hari Libur</h6>
                            </div>
                        </div>
                        <div class="card mx-3 my-3">
                            <div class="card-body">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>Input Hari Libur</strong>
                                            </div>
                                            <form action="{{ route('store-holiday') }}" method="post">
                                                @csrf
                                                <div class="card-body">
                                                    <table class="table table-bordered table-data" id="table-data">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Info</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="tr-clone">
                                                                <td>
                                                                    <input type="date" name="date[]" id=""
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="info[]" id=""
                                                                        class="form-control" required>
                                                                </td>
                                                                    <input type="hidden" name="dept[]" id="" class="form-control" value="{{ Auth::user()->dept }}">
                                                                <td>
                                                                    <a class="btn btn-info btn-remove">-</a>
                                                                    <a class="btn btn-warning btn-add">+</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <button class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col">
                                        <table class="table table-bordered" id="holiday-new">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Informasi</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($data as $item)
                                                    <tr>
                                                        <td>{{ $item->date }}</td>
                                                        <td>{{ $item->info }}</td>
                                                        <td>
                                                            <form action="{{ route('delete-holiday') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                                <button class="btn btn-danger btn-sm" style="margin-bottom: -17px;">-</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2">Belum ada data</td>
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
            $('#holiday-new').DataTable({
                "order": [[0, "desc"]]
            });
        });
    </script>

    <script>
        $(function() {
            $('.table-data').on('click', '.btn-add', function() {
                var $tr = $(this).closest('.tr-clone');
                var $clone = $tr.clone();
                $clone.find(':text').val('');
                $tr.after($clone);
            });
            $('.table-data').on('click', '.btn-remove', function() {
                var $tr = $(this).closest('.tr-clone');
                var $clone = $tr.clone();
                $clone.find(':text').val('');
                $tr.remove();
            });
        })
    </script>

</body>
