@include('admin.includes.head')
<link href="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' }}" rel="stylesheet" />

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
                                <h6 class="text-white text-capitalize ps-3">Data Training Input</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('store-training') }}" method="post">
                                        @csrf
                                        <table class="table table-bordered table-hover table-sm" id="table-data">
                                            <tr>
                                                <td colspan="2" style="background-color: bisque;">
                                                    <b>No</b>
                                                </td>
                                                <td colspan="3" style="background-color: bisque;">
                                                    <b>Kind</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="hidden" name="id_data"
                                                        value="{{ $training->count() + 1 }}-{{ $rom }}-{{ $year }}">
                                                    <input type="text" name="no" id=""
                                                        class="form-control form-control-sm"
                                                        value="{{ $training->count() + 1 }}/{{ $rom }}/{{ $year }}"
                                                        readonly>
                                                </td>
                                                <td colspan="3">
                                                    <select name="kind" id="" class="form-control" required>
                                                        <option value="internal">Internal</option>
                                                        <option value="external">External</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" style="background-color: bisque;">
                                                    <b>Topic Training</b>
                                                </td>
                                                <td colspan="2" style="background-color: bisque;">
                                                    <b>Nama Trainer</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <input type="text" name="topic" id=""
                                                        class="form-control form-control-sm"
                                                        placeholder="Masukan Topik Training" required>
                                                </td>
                                                <td colspan="2">
                                                    <select name="trainer" id=""
                                                        class="form-control form-control-sm select-trainer"
                                                        style="width: -webkit-fill-available;">
                                                        <option value="" selected disabled>-- Pilih Trainer --
                                                        </option>
                                                        @foreach ($user as $item)
                                                            <option value="{{ $item->nik }}">{{ $item->nik }} -
                                                                {{ $item->name }} | {{ $item->dept }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2" class="text-center"
                                                    style="background-color: bisque;">
                                                    <b>Tanggal Training</b>
                                                </td>
                                                <td style="background-color: bisque;">
                                                    <b>Tempat Training</b>
                                                </td>
                                                <td style="background-color: bisque;" colspan="2">
                                                    <b>Kategori Training</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="date" name="date_from" id=""
                                                        class="form-control form-control-sm" required>
                                                </td>
                                                <td>
                                                    <input type="date" name="date_to" id=""
                                                        class="form-control form-control-sm" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="place" id=""
                                                        class="form-control form-control-sm"
                                                        placeholder="Masukan Tempat Training" required>
                                                </td>
                                                <td colspan="2">
                                                    <select name="category" id="" class="form-control form-control-sm">
                                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                                        <option value="S">Safety</option>
                                                        <option value="E">Environmental</option>
                                                        <option value="Q">Quality</option>
                                                        <option value="HSEQ">HSEQ</option>
                                                        <option value="HRD & Legal">HRD & Legal</option>
                                                        <option value="IT">IT</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2" class="text-center"
                                                    style="background-color: bisque;"><b>Summary Materi Training</b>
                                                </td>
                                                <td colspan="3" class="text-center"
                                                    style="background-color: bisque;"><b>Komentar Trainer</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <textarea name="summary" cols="30" rows="10" style="width: -webkit-fill-available;"
                                                        placeholder="Isi dengan Summary Training"></textarea>
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="comment" id="" cols="30" rows="10" style="width: -webkit-fill-available;"
                                                        placeholder="Isi dengan Komentar Trainer"></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="5" class="text-center"
                                                    style="background-color: bisque;">
                                                    <b>Daftar Peserta</b>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class="text-center">NIK</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Dept</th>
                                                <th class="text-center">Score</th>
                                                <th class="text-center">Keterangan</th>
                                            </tr>
                                            @foreach ($user_att as $item)
                                                <tr class="tr_clone">
                                                    <td>
                                                        <input type="text" name="" id="nik"
                                                            value="{{ $item->nik }}" class="form-control nik"
                                                            readonly>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <select name="nik[]" class="form-control select-emp"
                                                                id="select-emp">
                                                                <option value="{{ $item->nik }}" selected
                                                                    class="text-center">
                                                                    {{ $item->name }}
                                                                </option>
                                                                @foreach ($user1 as $us)
                                                                    <option value="{{ $us->nik }}">
                                                                       {{ $us->nik }} - {{ $us->name }} | {{ $us->dept }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="" id="dept"
                                                            value="{{ $item->dept }}" class="form-control"
                                                            readonly>
                                                    </td>
                                                    <td>
                                                        <select name="score[]" id=""
                                                            class="form-control form-control-sm" required>
                                                            {{-- <option value="" selected disabled>-- Pilih Score --
                                                            </option> --}}
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4" selected>4</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            <input type="text" name="ket[]" id=""
                                                                class="form-control form-control-sm"
                                                                placeholder="Masukan keterangan">
                                                            <a id="add-btn"
                                                                class="btn btn-primary btn-sm tr_clone_add">+</a>
                                                            <a id="add-btn"
                                                                class="btn btn-warning btn-sm tr_clone_remove">-</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        <button class="btn btn-primary" style="float: right;">Simpan</button>
                                    </form>
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
    <script src="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js' }}"></script>
    <script>
        $(document).ready(function() {

            $('.select-emp').select2();
            $('.select-trainer').select2();
        });
    </script>
    <script>
        $('#table-data').on('click', '.tr_clone_add', function() {
            var $tr = $(this).closest('.tr_clone');
            var $clone = $tr.clone();
            $clone.find(':text').val('');
            $clone.find('span.select2').remove();
            $clone.find('.select').removeClass('select2-hidden-accessible');
            $clone.find('.select').removeAttr('data-select2-id');
            $tr.after($clone);
            $clone.find('.select-emp').select2();
        });

        $('#table-data').on('click', '.tr_clone_remove', function() {
            $tr = $(this).closest("tr").remove();
            $('.select-emp').select2();
        });
    </script>

    <script>
        $(function() {

            $('*[name=start_work]').appendDtpicker();
            $('*[name=end_work]').appendDtpicker();

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
</body>
