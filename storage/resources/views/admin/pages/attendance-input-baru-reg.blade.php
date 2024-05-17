@include('admin.includes.head')
<link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ 'https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css' }}">

<style>
    #header {
        position: sticky;
        top: 0;
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
                                <h6 class="text-white text-capitalize ps-3">Attendance Table - Input</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card text-bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Mohon Dibaca</h5>
                                    <p class="card-text">- Untuk karyawan yang cuti, jika cuti sudah dibuat maka
                                        karyawan tidak akan muncul di form absensi harian, silahkan klik <a
                                            href="{{ route('cuti') }}">Input
                                            Cuti</a></p>
                                    <p>- Untuk I, IP, IX, S & SX harus dengan keterangan.</p>
                                </div>
                            </div>

                            <form action="{{ route('store-absen-reg') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group">
                                                    <input type="date" class="form-control form-control-sm date"
                                                        name="date" required>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="yes"
                                                            name="no_tapping_day" id="cek-ntd">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            No Tapping Day
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="btn-grp text-right" style="float: right">
                                                    <button class="btn btn-primary btn-sm">Submit</button>
                                                    <a href="{{ route('attendance-reg') }}"
                                                        class="btn btn-secondary btn-sm"> Back</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <table class="table table-striped table-bordered table-responsive mt-5" id="table-data"
                                    data-toggle="table">

                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="align-middle text-center header" scope="col"
                                                id="header">NIK - Nama</th>
                                            <th colspan="3" class="align-middle text-center header" scope="col"
                                                id="header">Jam Masuk</th>
                                            <th colspan="3" class="align-middle text-center header" scope="col"
                                                id="header">Jam Pulang</th>
                                            <th rowspan="2" class="align-middle text-center header" scope="col"
                                                id="header">Kehadiran</th>
                                            <th rowspan="2" class="align-middle text-center header" scope="col"
                                                id="header">Keterangan</th>
                                        </tr>
                                        <tr>
                                            <th class="align-middle text-center header" scope="col" id="header">
                                                Jam</th>
                                            <th class="align-middle text-center header" scope="col" id="header">
                                                Info</th>
                                            <th class="align-middle text-center header" scope="col" id="header">
                                                File</th>
                                            <th class="align-middle text-center header" scope="col" id="header">
                                                Jam</th>
                                            <th class="align-middle text-center header" scope="col" id="header">
                                                Info</th>
                                            <th class="align-middle text-center header" scope="col" id="header">
                                                File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (Auth::user()->dept == 'Workshop' ||
                                                Auth::user()->dept == 'FSD' ||
                                                Auth::user()->dept == 'Security' ||
                                                Auth::user()->dept == 'HR Legal')
                                            @foreach ($user as $item)
                                                <tr class="tr-1">
                                                    <td>
                                                        <input type="hidden" name="date_select[]" id=""
                                                            class="form-control form-control-sm date_select_0">
                                                        <select name="user_id[]" id="name"
                                                            class="form-control form-control-sm nik">
                                                            <option value="{{ $item->nik }}">
                                                                {{ $item->nik }} -
                                                                {{ $item->name }} -
                                                                {{ $item->jabatan }} |
                                                                {{ $item->dept }}</option>

                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="time" name="start_work[]" id="start_work_0"
                                                            class="form-control form-control-sm start_work_0"
                                                            value="06:00">
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
                                                            class="form-control form-control-sm" value="14:00">
                                                    </td>

                                                    <td>
                                                        <input type="text" name="end_work_info[]"
                                                            class="form-control form-control-sm">
                                                    </td>

                                                    <td>
                                                        <input type="file" name="end_work_info_url[]"
                                                            class="form-control form-control-sm">
                                                    </td>

                                                    {{-- {{$item->leave->where('date', '=', $date)->count()}} --}}
                                                    {{-- @if ($item->leave->count() >= 1)
                                                    <td class="text-center" style="background: rgb(117, 117, 117)">
                                                        <select name="desc[]" id=""
                                                            class="form-control form-control-sm cek">
                                                            <option value="H" selected>Hadir (H)</option>
                                                            <option value="M">Mangkir (M)</option>
                                                            <option value="MX">Tidak Hadir (MX)</option>
                                                            <option value="I">Izin (I)</option>
                                                            <option value="IX">Izin Tidak Dibayar (IX)
                                                            </option>
                                                            <option value="S">Sakit (S)</option>
                                                            <option value="SX">Sakit Tidak Dibayar (SX)
                                                            </option>
                                                            <option value="C">Cuti (C)</option>
                                                        </select>
                                                    </td> --}}
                                                    <td class="text-center">
                                                        <select name="desc[]" id="desc1"
                                                            class="form-control form-control-sm cek">
                                                            <option value="H" selected>Hadir (H)</option>
                                                            <option value="D">Dinas (D)</option>
                                                            <option value="M">Mangkir (M)</option>
                                                            <option value="MX">Tidak Hadir (MX)</option>
                                                            <option value="I">Izin (I)</option>
                                                            <option value="IP">Izin Pribadi (IP)</option>
                                                            @if ($item->leave->count() > 12)
                                                            <option value="IX">Izin Tidak Dibayar (IX)
                                                            </option>

                                                            @endif

                                                            @if (Auth::user()->dept == 'HR Legal')
                                                            <option value="S" class="S">Sakit (S)</option>
                                                            @endif
                                                            <option value="SX">Sakit Tidak Dibayar (SX)
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        {{-- <input type="text" name="info[]"
                                                            class="form-control form-control-sm info"> --}}
                                                        <div class="info-area" id="info-area">
                                                            <input type="text" name="info[]"
                                                                class="form-control form-control-sm info">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach ($user as $item => $mandor)
                                                <tr>
                                                    <th colspan="9">
                                                        <h5>Mandor: {{ $item }}</h5>
                                                    </th>
                                                </tr>
                                                @foreach ($mandor as $itemx)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="date_select[]" id=""
                                                                class="form-control form-control-sm date_select_0">
                                                            <select name="user_id[]" id="name"
                                                                class="form-control form-control-sm nik">
                                                                <option value="{{ $itemx->user_subs->nik }}">
                                                                    {{ $itemx->user_subs->nik }} -
                                                                    {{ $itemx->user_subs->name }} -
                                                                    {{ $itemx->user_subs->jabatan }} |
                                                                    {{ $itemx->user_subs->dept }}</option>

                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="time" name="start_work[]"
                                                                id="start_work_0"
                                                                class="form-control form-control-sm start_work_0"
                                                                value="06:00">
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
                                                                class="form-control form-control-sm" value="14:00">
                                                        </td>

                                                        <td>
                                                            <input type="text" name="end_work_info[]"
                                                                class="form-control form-control-sm">
                                                        </td>

                                                        <td>
                                                            <input type="file" name="end_work_info_url[]"
                                                                class="form-control form-control-sm">
                                                        </td>

                                                        {{-- {{$itemx->user_subs->leave->whereBetween('', $date)->count()}} --}}
                                                        {{-- {{ \Carbon\CarbonPeriod::create('2022-01-01', '2022-01-10') }} --}}
                                                        {{-- {{$itemx->user_subs->leave->count()}}  --}}
                                                        {{-- @if ($itemx->user_subs->leave->count() > 1)
                                                            <td class="text-center" style="background: rgb(120, 120, 120)">
                                                                <select name="desc[]" id=""
                                                                    class="form-control form-control-sm cek">
                                                                    <option value="H" selected>Hadir (H)</option>
                                                                    <option value="M">Mangkir (M)</option>
                                                                    <option value="MX">Tidak Hadir (MX)</option>
                                                                    <option value="I">Izin (I)</option>
                                                                    <option value="IX">Izin Tidak Dibayar (IX)
                                                                    </option>
                                                                    <option value="S">Sakit (S)</option>
                                                                    <option value="SX">Sakit Tidak Dibayar (SX)
                                                                    </option>
                                                                    <option value="C">Cuti (C)</option>
                                                                </select>
                                                            </td>
                                                        @else --}}
                                                        <td class="text-center">
                                                            <select name="desc[]" id="desc1"
                                                                class="form-control form-control-sm cek">
                                                                <option value="H" selected>Hadir (H)</option>
                                                                <option value="M">Mangkir (M)</option>
                                                                <option value="MX">Tidak Hadir (MX)</option>
                                                                <option value="I">Izin (I)</option>
                                                                <option value="IP">Izin Pribadi (IP)</option>
                                                                @if ($itemx->leave->count() > 12)
                                                                <option value="IX">Izin Tidak Dibayar (IX)
                                                                </option>

                                                                @endif

                                                                @if (Auth::user()->dept == 'HR Legal')
                                                                <option value="S" class="S">Sakit (S)</option>
                                                                @endif
                                                                <option value="SX">Sakit Tidak Dibayar (SX)
                                                                </option>
                                                            </select>
                                                        <td>
                                                            <input type="text" name="info[]"
                                                                class="form-control form-control-sm">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                {{-- <tr class="tr-clone-0" id="uploadrow_0">
                                            <td>
                                              <input type="hidden" name="date_select[]" id="" class="form-control form-control-sm date_select_0">
                                                <select name="user_id[]" id="name"
                                                    class="form-control form-control-sm nik">
                                                    <option value="{{ $item->user->id }}">{{ $item->user_subs->nik }} -
                                                        {{ $item->user_subs->name }} - {{ $item->user_subs->jabatan }} |
                                                        {{ $item->user_subs->dept }}</option>

                                                </select>
                                            </td>

                                            <td>
                                                <input type="time" name="start_work[]" id="start_work_0"
                                                    class="form-control form-control-sm start_work_0"
                                                    value="06:00">
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
                                                    class="form-control form-control-sm" value="14:00">
                                            </td>

                                            <td>
                                                <input type="text" name="end_work_info[]"
                                                    class="form-control form-control-sm">
                                            </td>

                                            <td>
                                                <input type="file" name="end_work_info_url[]"
                                                    class="form-control form-control-sm">
                                            </td>

                                            {{-- <td>
                                                <input type="text" name="desc[]"
                                                    class="form-control form-control-sm desc_0" id="desc_0"
                                                    value="H">
                                            </td> --}}
                                                {{-- @foreach ($item->leave->where('date', '=', $date) as $itemx)
                                               {{$itemx->empty}}
                                           @endforeach --}}


                                                </tr>
                                            @endforeach
                                        @endif
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
    <script src="{{ 'https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js' }}"></script>

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
        });

        $('body').on('click', '#cek-ntd', function() {
            if ($('#cek-ntd').is(':checked')) {
                $('.cek-opt').val('NT');
                $('.cek-opt').text('No Tapping (NT)');
            } else {
                $('.cek-opt').val('H');
                $('.cek-opt').text('Hadir (H)');
            }
        });

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

            // if (start_work >= '08:05:00' && start_work_info == '' && start_work_info_url == '') {
            //     desc.val('L');
            // } else if (start_work >= '08:05:00' && start_work_info != '' && start_work_info_url == '') {
            //     desc.val('IX');
            // } else if (start_work >= '08:05:00' && start_work_info != '' && start_work_info_url != '') {
            //     desc.val('I');
            // } else {
            //     desc.val('');
            // }

            // if (start_work_info == 'Sakit' || start_work_info == 'sakit' && start_work_info_url == ''){
            //   desc.val('SX');
            // } else if (start_work_info == 'Sakit' || start_work_info == 'sakit' && start_work_info_url != ''){
            //   desc.val('S');
            // }


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
</body>
