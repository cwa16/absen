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
                                        <form action="{{ route('store-work-hour') }}" method="post">
                                            @csrf
                                            <label for="name">Group</label>
                                            <input type="text" name="name_work" id=""
                                                class="form-control form-control-sm">

                                            <div class="row">
                                                <div class="col">
                                                    <label for="" class="mt-2">Dept</label>
                                                    <select class="form-control dept" name="dept[]" id="dept"
                                                        size="10" multiple multiselect-search="true">
                                                        <option value="" selected disabled>-- Select
                                                            Dept --
                                                        </option>
                                                        @foreach ($dept as $item)
                                                            <option value="{{ $item->dept }}">
                                                                {{ $item->dept }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="" class="mt-2">Jabatan</label>
                                                    <select class="form-control mt-2 position" name="position[]" id="position"
                                                        size="10" multiple>
                                                        <option value="" selected disabled>-- Select --</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div style="overflow: auto;">
                                                <table class="table table-bordered mt-2">
                                                    <tr>
                                                        <th class="align-middle text-center" colspan="2"
                                                            style="background: rgb(208, 208, 208);">Senin</th>
                                                        <th class="align-middle text-center" colspan="2"
                                                            style="background: rgb(208, 208, 208);">Selasa</th>
                                                        <th class="align-middle text-center" colspan="2"
                                                            style="background: rgb(208, 208, 208);">Rabu</th>

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
                                                                class="form-control align-middle text-center" required>
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
                                                                class="form-control align-middle text-center" required>
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
                                                                class="form-control align-middle text-center" required>
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
                                                        <th class="align-middle text-center" colspan="2"
                                                            style="background: rgb(208, 208, 208);">Kamis</th>
                                                        <th class="align-middle text-center" colspan="2"
                                                            style="background: rgb(208, 208, 208);">Jum'at</th>
                                                        <th class="align-middle text-center" colspan="2"
                                                            style="background: rgb(208, 208, 208);">Sabtu</th>
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
                                                                class="form-control align-middle text-center" required>
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
                                                                class="form-control align-middle text-center" required>
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
                                                                class="form-control align-middle text-center" required>
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
                                        <table class="" id="workTable" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle text-center" rowspan="2">Group</th>
                                                    <th class="align-middle text-center" rowspan="2"
                                                        style="width: 100px;">Dept.</th>
                                                    <th class="align-middle text-center" rowspan="2"
                                                        style="width: 200px;">Position</th>
                                                    <th class="align-middle text-center" colspan="2">Senin</th>
                                                    <th class="align-middle text-center" colspan="2">Selasa</th>
                                                    <th class="align-middle text-center" colspan="2">Rabu</th>
                                                    <th class="align-middle text-center" colspan="2">Kamis</th>
                                                    <th class="align-middle text-center" colspan="2">Jum'at</th>
                                                    <th class="align-middle text-center" colspan="2">Sabtu</th>
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
                                                        <td>{{ $item->name }}
                                                            <a href="{{ route('delete-work-hour', $item->id) }}"
                                                                class="delete btn btn-danger"><i
                                                                    class="fa-solid fa-trash"></i>
                                                            </a>
                                                            <a href="{{ route('edit-work-hour', $item->id) }}"
                                                                class="btn btn-success"><i
                                                                    class="fa-solid fa-edit"></i></a>
                                                        </td>
                                                        <td class="table-bordered">
                                                            @foreach ($item->group_in_dept as $dept)
                                                                <div class="table-bordered">{{ $dept }}</div>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($item->group_in as $jab)
                                                                <div class="table-bordered">
                                                                    {{ $jab }}
                                                                </div>
                                                            @endforeach
                                                        </td>
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

            $('.dept').bsMultiSelect();

        });


    </script>

    <script>
         $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.dept').change(function() {
                $.ajax({
                    url: '{{ route('set-work-hour-select-dept') }}',
                    method: 'POST',
                    data: {
                        dept: $(this).val()
                    },
                    success: function(response) {
                        $('.position').empty();

                        $.each(response.jabatan, function(data, data) {
                            $('.position').append(new Option(data, data));
                        });

                        $('.position').bsMultiSelect();
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
