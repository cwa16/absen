@include('admin.includes.head')
<link href="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' }}">
<link rel="stylesheet" href="{{ 'https://cdn.jsdelivr.net/gh/loadingio/ldbutton@v1.0.1/dist/ldbtn.min.css' }}">

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
                                <h6 class="text-white text-capitalize ps-3">Attendance Table - Input Regular (Import
                                    dari Excel)</h6>
                            </div>
                        </div>
                        <div class="card-body">

                            

                            <div class="row mt-2">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ route('import-excel') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <label>Pilih file excel</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="file" name="file"
                                                        required="required">

                                                    <button class="btn btn-success mt-3" type="submit"
                                                        id="btn-import">Import</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                          <div class="col">
                            <div class="card">
                              <div class="card-body text-center">
                                <form action="{{ route('delete-import') }}" method="post">
                                  @csrf
                                  <button class="btn btn-danger">Kosongkan Data</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <label for="">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm date"
                                            name="date">
                                    </div>

                                    <div class="col">
                                        <form action="{{ route('store-import') }}" method="post">
                                            @csrf
                                            <br>
                                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>                    
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <table class="table table-striped table-bordered table-responsive mt-3">

                            <thead>
                                <tr>
                                    <th class="align-middle text-center">NIK - Nama</th>
                                    <th class="align-middle text-center">Jam Masuk</th>
                                    <th class="align-middle text-center">Jam Pulang</th>
                                    <th class="align-middle text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>


                                @forelse ($absen as $item)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="date_select[]" class="date_select"
                                                id="" required>
                                            <select name="user_id[]" id=""
                                                class="form-control form-control-sm">
                                                <option value="{{ $item->user->nik }}">{{ $item->user->nik }} -
                                                    {{ $item->user->name }}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="time" class="form-control form-control-sm"
                                                name="start_work[]" id=""
                                                value="{{ \Carbon\Carbon::parse($item->start_work)->format('H:i') }}">
                                        </td>
                                        <td>
                                            <input type="time" class="form-control form-control-sm" name="end_work[]"
                                                value="{{ \Carbon\Carbon::parse($item->end_work)->format('H:i') }}">
                                        </td>
                                        <td>
                                            <input type="text" name="desc[]" id=""
                                                class="form-control form-control-sm" value="{{ $item->desc }}">
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="4" class="text-center">
                                        <h3>Tidak ada data</h3>
                                    </td>
                                @endforelse

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
    <script src="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js' }}"></script>
    <script>
        $('body').on('change', '.date', function() {

            var date_select = $('.date_select');
            var date = $('.date').val();
            date_select.val(date);
        });
    </script>

</body>
