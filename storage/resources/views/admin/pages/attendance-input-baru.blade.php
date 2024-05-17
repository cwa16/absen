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
                                <h6 class="text-white text-capitalize ps-3">Attendance Table - Input</h6>
                            </div>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('store-absen') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col">
                                                <label for="">Tanggal</label>
                                                <input type="date" class="form-control form-control-sm date"
                                                    name="date" required>
                                            </div>
                                            <div class="col">
                                                <br>
                                                <button class="btn btn-primary btn-sm">Submit</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <table class="table table-striped table-bordered table-responsive mt-5" id="table-data">

                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="align-middle text-center">NIK - Nama</th>
                                            <th colspan="3" class="align-middle text-center">Jam Masuk</th>
                                            <th colspan="3" class="align-middle text-center">Jam Pulang</th>
                                            <th rowspan="2" colspan="2" class="align-middle text-center">Keterangan</th>
                                            <th rowspan="2" class="align-middle text-center">Action</th>
                                        </tr>
                                        <tr>
                                            <th class="align-middle text-center">Jam</th>
                                            <th class="align-middle text-center">Info</th>
                                            <th class="align-middle text-center">File</th>
                                            <th class="align-middle text-center">Jam</th>
                                            <th class="align-middle text-center">Info</th>
                                            <th class="align-middle text-center">File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tr-clone-0" id="uploadrow_0">
                                            <td>
                                                <select name="user_id[]" id="name"
                                                    class="form-control form-control-sm nik">

                                                    @foreach ($user as $item)
                                                        <option value="{{ $item->nik }}">{{ $item->nik }} -
                                                            {{ $item->name }} - {{ $item->jabatan }} |
                                                            {{ $item->dept }}</option>
                                                    @endforeach

                                                </select>
                                            </td>

                                            <input type="hidden" name="date_select[]" id=""
                                                class="form-control form-control-sm date_select_0">

                                            <td>
                                                <input type="time" name="start_work[]" id="start_work_0"
                                                    class="form-control form-control-sm start_work_0">
                                            </td>

                                            <td>
                                                <input type="text" name="start_work_info[]"
                                                    class="form-control form-control-sm start_work_info_0"
                                                    id="start_work_info_0">
                                            </td>

                                            <td>
                                                <input type="file" name="start_work_info_url[]"
                                                    class="form-control form-control-sm start_work_info_url_0"
                                                    id="start_work_info_url_0">
                                            </td>

                                            <td>
                                                <input type="time" name="end_work[]" id=""
                                                    class="form-control form-control-sm">
                                            </td>

                                            <td>
                                                <input type="text" name="end_work_info[]"
                                                    class="form-control form-control-sm">
                                            </td>

                                            <td>
                                                <input type="file" name="end_work_info_url[]"
                                                    class="form-control form-control-sm">
                                            </td>

                                            <td class="text-center">
                                                <select name="desc[]" id="desc1"
                                                    class="form-control form-control-sm cek">
                                                    <option value="H" selected>Hadir (H)</option>
                                                    <option value="D">Dinas (D)</option>
                                                    <option value="M">Mangkir (M)</option>
                                                    <option value="MX">Tidak Hadir (MX)</option>
                                                    <option value="I">Izin (I)</option>
                                                    <option value="IP">Izin Pribadi (IP)</option>
                                                    <option value="IX">Izin Tidak Dibayar (IX)
                                                    </option>

                                                    @if (Auth::user()->dept == 'HR Legal')
                                                        <option value="S" class="S">Sakit (S)</option>
                                                    @endif
                                                    <option value="SX">Sakit Tidak Dibayar (SX)
                                                    </option>
                                                </select>
                                            <td>
                                                <div class="info-area" id="info-area">
                                                    <input type="text" name="info[]"
                                                        class="form-control form-control-sm info">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="button" value="Add"
                                                    class="btn btn-success btn-sm tr-clone-add">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

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
        $(document).ready(function() {
            $('#name').select2();
        });
    </script>
    <script>
        $('#table-data').on('click', '.tr-clone-add', function() {
            // $tr = $(this).closest(".tr-clone_0").next().clone();
            // $tr.insertAfter($(this).closest(".tr-clone_0"));

            var $tr = $(this).closest('.tr-clone-0');
            var $clone = $tr.clone();

            $tr.after($clone);
        });
    </script>

    <script>
        $('body').on('change', '.date', function() {

            var date_select = $('.date_select_0');
            var date = $('.date').val();
            date_select.val(date);
        })

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

        $("#table-data").on("change", "input", function() {
            // Get the row containing the input
            var row = $(this).closest("tr");

            // Get the values from _this row's_ inputs, using `row.find` to
            // look only within this row
            var start_work = row.find('.start_work_0').val();
            var start_work_info = row.find('.start_work_info_0').val();
            var start_work_info_url = row.find('.start_work_info_url_0').val();
            var desc = row.find('.desc_0');

            if (start_work >= '08:05:00' && start_work_info == '' && start_work_info_url == '') {
                desc.val('L');
            } else if (start_work >= '08:05:00' && start_work_info != '' && start_work_info_url == '') {
                desc.val('IX');
            } else if (start_work >= '08:05:00' && start_work_info != '' && start_work_info_url != '') {
                desc.val('I');
            } else {
                desc.val('');
            }

            if (start_work_info == 'Sakit' || start_work_info == 'sakit' && start_work_info_url == '') {
                desc.val('SX');
            } else if (start_work_info == 'Sakit' || start_work_info == 'sakit' && start_work_info_url != '') {
                desc.val('S');
            }


            // ...
        });
    </script>

    {{-- <script>
      var $on = 1;
        $('#table-data').on('click', '.tr-clone-add', function() {
            var $tr = $(this).closest('.tr-clone_0');
            var $clone = $tr.clone();

            $clone.find('.start_work_0').each(function() {
                $(this).attr('class', 'form-control form-control-sm start_work_' + $on);
            });

            $clone.find('.start_work_info_0').each(function() {
                $(this).attr('class', 'form-control form-control-sm start_work_info_' + $on);
            });

            $clone.find('.start_work_info_url_0').each(function() {
                $(this).attr('class', 'form-control form-control-sm start_work_info_url_' + $on);
            });

            $clone.find('.desc_0').each(function() {
                $(this).attr('class', 'form-control form-control-sm desc_' + $on);
            });


            $tr.after($clone);
            $on++;
        });
    </script>
    <script>
        var $ono = 1;

            $('table > tbody  > tr').each(function(index, tr) {
                var start_work = $('.start_work_'+index).val();
                var start_work_info = $('.start_work_info_'+index);
                console.log(start_work);

                $('.start_work_0, .start_work_info_0, .start_work_info_url_0').on('change', function() {
                  start_work_info.val(start_work);
                  console.log(tr);
                });
            });


            // var start_work_info = $('.start_work_info').val();
            // var start_work_info_url = $('.start_work_info_url').val();
            // var desc = $('.desc');

            // if (start_work >= '08:05:00' && start_work_info == '' && start_work_info_url == '') {
            //     desc.val('L');
            // } else if ($('.start_work').val() >= '08:05:00' && $('.start_work_info').val() != '' && $(
            //         '.start_work_info_url').val() == '') {
            //     $('.desc').val('IX');
            // } else if ($('.start_work').val() >= '08:05:00' && $('.start_work_info').val() != '' && $(
            //         '.start_work_info_url').val() != '') {
            //     $('.desc').val('I');
            // } else {
            //     $('.desc').val('');
            // }

            // $ono++;
    </script> --}}

    <script type="text/javascript">
        $(function() {

            var table = $('#table-attendance-now').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('attendance-now') }}",
                columns: [{
                        data: 'user',
                        name: 'user.name'
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
                        data: 'end_work',
                        name: 'end_work'
                    },
                ]
            });

            $('body').on('click', '.btn-tambah', function() {
                // Do this before you initialize any of your modals

                $('#ajax-book-model-tambah').modal('show');

            });



        });
    </script>
</body>
