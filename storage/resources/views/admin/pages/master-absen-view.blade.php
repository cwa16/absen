@include('admin.includes.head')
<link href="{{ asset('css/select2.css') }}" rel="stylesheet" />

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
                                <h6 class="text-white text-capitalize ps-3">Master Absensi</h6>
                            </div>
                        </div>

                        <div class="card-body">


                            <form action="{{ route('master-absen-update') }}" method="post">
                                <a href="#" class="btn btn-secondary btn-edit" id="btn-edit">Edit</a>
                                <button class="btn btn-primary" type="submit">Update</button>
                                <div class="table-responsive p-0">
                                    <table class="table table-striped table-bordered table-sm align-items-center mb-0"
                                        id="table-data" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Date</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    NIK</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Name</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Dept</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Start Work</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    End Work</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Desc</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($master_absen as $key => $item)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                                                    <td>{{ $item->nik }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->dept }}</td>
                                                    <td>
                                                        <input type="input" name="start_work[]" class="form-control start-work desc-input" id="start-work" value="{{ $item->start_work ?? 0 }}" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="input" name="end_work[]" class="form-control end-work desc-input" id="" value="{{ $item->end_work ?? 0 }}" disabled>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <select class="form-control desc-input cek" name="desc[]"
                                                                id="" disabled>
                                                                <option value="{{ $item->desc }}" selected>
                                                                    {{ $item->desc }}
                                                                </option>
                                                                <option class="cek-opt" value="H">Hadir (H)
                                                                </option>
                                                                <option value="D">Dinas (D)
                                                                </option>
                                                                <option value="M">Mangkir (M)</option>
                                                                <option value="MX">Tidak Hadir (MX)</option>
                                                                <option value="I">Izin (I)</option>
                                                                <option value="IX">Izin Tidak Dibayar (IX)
                                                                </option>
                                                                <option value="S">Sakit (S)</option>
                                                                <option value="SX">Sakit Tidak Dibayar (SX)
                                                                </option>
                                                                <option value="TA">Tidak Absen (TA)
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{-- <input type="text" name="info[]"
                                                            class="form-control form-control-sm info"> --}}
                                                        <div class="info-area" id="info-area">
                                                            <input type="text" name="info[]"
                                                                class="form-control form-control-sm info desc-input" value="{{ $item->info }}" disabled>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('master-absen-delete-item', $item->id) }}"
                                                            class="btn btn-danger btn-sm">Delete</a>
                                                        <input type="hidden" name="idx[]" class="form-control"
                                                            value="{{ $item->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    <script src="{{ asset('js/select2.js') }}"></script>
    <script>
        $('body').on('click', '#btn-edit', function() {
            $('.desc-input').attr('disabled', false)
                .siblings().attr('disabled', true);


        });
    </script>
    <script>
        $(document).ready(function() {
            $('#table-attendance-now').DataTable();
        });
    </script>
    <script>
        $(function() {

            $('.start-work').appendDtpicker();
            $('.end-work').appendDtpicker();

        });
    </script>

    <script>
        $('#table-data').on('change', '.cek', function() {
            var sxlist = @json($sxlists);
            var row = $(this).closest("tr");
            var cond = false;
            if (row.find('.cek').val() == 'S' || row.find('.cek').val() == 'SX') {

                $.each(sxlist, function(key, value) {
                    options = options + '<option value="' + value.name + '">' + value.code + '. ' +
                        value
                        .name +
                        '</option>'

                });

                var infohtml = '<select name="info[]" class="form-control form-control-sm info" id="info">' +
                    options +
                    '<option class="tambah-sakit" value="lain-lain">Lain-lain</option>'
                '</select>';

                row.find('.info-area').html(infohtml);

                row.find('span.select2').remove();
                row.find('.select').removeClass('select2-hidden-accessible');
                row.find('.select').removeAttr('data-select2-id');

                row.find('.info').select2();

                return false;

            }

            var input_info = '<input name="info[]" class="form-control form-control-sm">';
            row.find('.info-area').html(input_info);

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

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
                                    var oTable = $('#table-attendance-now').dataTable();
                                    oTable.fnDraw(false);
                                }
                            });
                        }
                    }
    </script>


</body>
