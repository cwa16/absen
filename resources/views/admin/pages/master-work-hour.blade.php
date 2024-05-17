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
                                <h6 class="text-white text-capitalize ps-3">Master Jam Kerja
                            </div>
                        </div>
                        <div class="card mx-3 my-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <form action="{{ route('store-master-work-hour') }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <label for="start_work">Jam Masuk</label>
                                                    <input type="time" name="start_work" id="" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label for="end_work">Jam Pulang</label>
                                                    <input type="time" name="end_work" id="" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label for="ket">Keterangan</label>
                                                    <input type="text" name="ket" id="" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <button
                                                    class="btn btn-primary btn-sm mt-2 form-control mt-4">Save</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-striped table-bordered table-sm" id="workTable">
                                            <thead>
                                                <tr>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($workhour as $item)
                                                    <tr>
                                                        <td>{{ $item->start_work }}</td>
                                                        <td>{{ $item->end_work }}</td>
                                                        <td>{{ $item->ket }}</td>
                                                        <td>
                                                            <a href="{{ route('delete-work-hour-master', $item->id) }}"
                                                                class="delete btn btn-danger"><i
                                                                    class="fa-solid fa-trash"></i>
                                                            </a>
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

    <script>
        $(document).ready(function() {
            $('#workTable').DataTable({
                "order": [
                    [0, "desc"]
                ]
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
