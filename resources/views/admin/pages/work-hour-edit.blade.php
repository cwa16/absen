@include('admin.includes.head')
<style>
    #workTable {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #workTable td,
    #workTable th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #workTable tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #workTable tr:hover {
        background-color: #ddd;
    }

    #workTable th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>

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
                                        <a href="{{ route('work-hour') }}" class="btn btn-secondary">Back</a>
                                        <form action="{{ route('store-work-hour') }}" method="post">
                                            @csrf
                                            <label for="name">Divisi</label>
                                            <input type="text" name="name_work" id="" value="{{ $data->name }}"
                                                class="form-control form-control-sm" readonly>

                                                <td>
                                                    <label for="" class="mt-3">Dept</label>
                                                    <select class="form-control" name="dept[]" id="dept" multiple>
                                                        @foreach ($data->group_in_dept as $item)
                                                            <option value="{{ $item }}" selected>{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <label for="" class="mt-3">Jabatan</label>
                                                    <select class="form-control" name="position[]" id="position" multiple>
                                                        @foreach ($data->group_in as $item)
                                                            <option value="{{ $item }}" selected>{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>


                                            <div style="overflow: auto;">
                                                <table class="table table-bordered mt-5">
                                                    <tr>
                                                        <th class="align-middle text-center" colspan="2">Senin</th>
                                                        <th class="align-middle text-center" colspan="2">Selasa</th>
                                                        <th class="align-middle text-center" colspan="2">Rabu</th>

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
                                                            <select name="senin" id="senin"
                                                                class="form-control align-middle text-center" >
                                                                <option value="" selected disabled>-- pilih --
                                                                </option>
                                                                @foreach ($workhour_master as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->start_work }} - {{ $item->end_work }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td colspan="2">
                                                            <select name="selasa" id="selasa"
                                                                class="form-control align-middle text-center" >
                                                                <option value="" selected disabled>-- pilih --
                                                                </option>
                                                                @foreach ($workhour_master as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->start_work }} - {{ $item->end_work }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td colspan="2">
                                                            <select name="rabu" id="rabu"
                                                                class="form-control align-middle text-center" >
                                                                <option value="" selected disabled>-- pilih --
                                                                </option>
                                                                @foreach ($workhour_master as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->start_work }} -
                                                                        {{ $item->end_work }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-center" colspan="2">Kamis</th>
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
                                                            <select name="kamis" id="kamis"
                                                                class="form-control align-middle text-center" >
                                                                <option value="" selected disabled>-- pilih --
                                                                </option>
                                                                @foreach ($workhour_master as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->start_work }} -
                                                                        {{ $item->end_work }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td colspan="2">
                                                            <select name="jumat" id="jumat"
                                                                class="form-control align-middle text-center" >
                                                                <option value="" selected disabled>-- pilih --
                                                                </option>
                                                                @foreach ($workhour_master as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->start_work }} -
                                                                        {{ $item->end_work }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td colspan="2">
                                                            <select name="sabtu" id="sabtu"
                                                                class="form-control align-middle text-center" >
                                                                <option value="" selected disabled>-- pilih --
                                                                </option>
                                                                <option value="">LIBUR</option>
                                                                @foreach ($workhour_master as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->start_work }} -
                                                                        {{ $item->end_work }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <button
                                                class="btn btn-primary btn-sm mt-2 form-control form-control-sm">Save</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <table class="" id="workTable">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle text-center" rowspan="2">Name</th>
                                                    <th class="align-middle text-center" rowspan="2">Dept</th>
                                                    <th class="align-middle text-center" rowspan="2">Position</th>
                                                    <th class="align-middle text-center" colspan="2">Senin</th>
                                                    <th class="align-middle text-center" colspan="2">Selasa</th>
                                                    <th class="align-middle text-center" colspan="2">Rabu</th>
                                                    <th class="align-middle text-center" colspan="2">Kamis</th>
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
                                                        <td>{{ $item->group_in_dept }}</td>
                                                        <td>{{ $item->group_in }}</td>
                                                        <td>{{ $item->start_work_senin }}</td>
                                                        <td>{{ $item->end_work_senin }}</td>
                                                        <td>{{ $item->start_work_selasa }}</td>
                                                        <td>{{ $item->end_work_selasa }}</td>
                                                        <td>{{ $item->start_work_rabu }}</td>
                                                        <td>{{ $item->end_work_rabu }}</td>
                                                        <td>{{ $item->start_work_kamis }}</td>
                                                        <td>{{ $item->end_work_kamis }}</td>
                                                        <td>{{ $item->start_work_jumat }}</td>
                                                        <td>{{ $item->end_work_jumat }}</td>
                                                        @if (!$item->start_work_sabtu && !$item->end_work_sabtu)
                                                            <td class="text-center">LIBUR</td>
                                                            <td class="text-center">LIBUR</td>
                                                        @else
                                                            <td>{{ $item->start_work_sabtu }}</td>
                                                            <td>{{ $item->end_work_sabtu }}</td>
                                                        @endif
                                                        <td>
                                                            <a href="{{ route('delete-work-hour', $item->id) }}"
                                                                class="delete btn btn-danger"><i
                                                                    class="fa-solid fa-trash"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-success"><i class="fa-solid fa-edit"></i></a>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#dept').click(function() {
                $.ajax({
                    url: '{{ route('set-work-hour-select-dept') }}',
                    method: 'POST',
                    data: {
                        dept: $(this).val()
                    },
                    success: function(response) {
                        $('#position').empty();

                        $.each(response.jabatan, function(data, data) {
                            $('#position').append(new Option(data, data))
                        })
                    }
                });
            });

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
