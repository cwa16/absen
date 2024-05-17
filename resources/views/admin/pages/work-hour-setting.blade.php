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
                                <h6 class="text-white text-capitalize ps-3">Set Jam Kerja
                            </div>
                        </div>
                        <div class="card mx-3 my-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <form action="{{ route('store-work-hour-setting') }}" method="post">
                                            @csrf
                                            <label for="name">Divisi</label>
                                            <select name="workhourId" id="" class="form-control">
                                                <option value="" selected disabled>-- pilih --</option>
                                                @foreach ($workhour as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <table class="table table-bordered mt-2">
                                                <tr>
                                                    <th class="align-middle text-center" colspan="2">Senin - Kamis
                                                    </th>
                                                    <th class="align-middle text-center" colspan="2">Jum'at</th>
                                                    <th class="align-middle text-center" colspan="2">Sabtu</th>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-center">Jam Masuk</td>
                                                    <td class="align-middle text-center">Jam Keluar</td>
                                                    <td class="align-middle text-center">Jam Masuk</td>
                                                    <td class="align-middle text-center">Jam Keluar</td>
                                                    <td class="align-middle text-center">Jam Masuk</td>
                                                    <td class="align-middle text-center">Jam Keluar</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <select name="start_work_sk" id="" class="form-control align-middle text-center">
                                                            <option value="" selected disabled>-- pilih --</option>
                                                            @foreach ($workhour_master->where('day', 'sk') as $item)
                                                                <option value="{{ $item->id }}">{{ $item->start_work }} - {{ $item->end_work }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td colspan="2">
                                                        <select name="start_work_j" id="" class="form-control align-middle text-center">
                                                            <option value="" selected disabled>-- pilih --</option>
                                                            @foreach ($workhour_master->where('day', 'j') as $item)
                                                                <option value="{{ $item->id }}">{{ $item->start_work }} - {{ $item->end_work }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td colspan="2">
                                                        <select name="start_work_s" id="" class="form-control align-middle text-center">
                                                            <option value="" selected disabled>-- pilih --</option>
                                                            <option value="">LIBUR</option>
                                                            @foreach ($workhour_master->where('day', 's') as $item)
                                                                <option value="{{ $item->id }}">{{ $item->start_work }} - {{ $item->end_work }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                            <button
                                                class="btn btn-primary btn-sm mt-2 form-control form-control-sm">Update</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-striped table-bordered table-sm" id="workTable">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle text-center" rowspan="2">Divisi</th>
                                                    <th class="align-middle text-center" colspan="2">Senin - Kamis
                                                    </th>
                                                    <th class="align-middle text-center" colspan="2">Jum'at</th>
                                                    <th class="align-middle text-center" colspan="2">Sabtu</th>
                                                    <th class="align-middle text-center" rowspan="2">Action</th>
                                                </tr>
                                                <tr>
                                                    <th class="align-middle text-center">Jam Masuk</th>
                                                    <th class="align-middle text-center">Jam Pulang</th>
                                                    <th class="align-middle text-center">Jam Masuk</th>
                                                    <th class="align-middle text-center">Jam Pulang</th>
                                                    <th class="align-middle text-center">Jam Masuk</th>
                                                    <th class="align-middle text-center">Jam Pulang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($workhour as $key => $item)
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->start_work_sk }}</td>
                                                        <td>{{ $item->end_work_sk }}</td>
                                                        <td>{{ $item->start_work_j }}</td>
                                                        <td>{{ $item->end_work_j }}</td>
                                                        @if (!$item->start_work_s && !$item->end_work_s)
                                                            <td class="text-center">LIBUR</td>
                                                            <td class="text-center">LIBUR</td>
                                                        @else
                                                            <td>{{ $item->start_work_s }}</td>
                                                            <td>{{ $item->end_work_s }}</td>
                                                        @endif
                                                        <td>
                                                            <a href="{{ route('delete-work-hour', $item->id) }}"
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
