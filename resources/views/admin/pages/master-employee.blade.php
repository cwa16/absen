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
                                <h6 class="text-white text-capitalize ps-3">Master Employee</h6>
                            </div>
                        </div>

                        <!-- boostrap add and edit book model -->
                        <div class="modal fade" id="ajax-book-model" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="ajaxBookModel"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm"
                                            class="form-horizontal" method="POST">
                                            <input type="hidden" name="id" id="id">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Name</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="names"
                                                        name="names" placeholder="Enter Employee Name" maxlength="50"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Start Work</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" id="start_work"
                                                        name="start_work" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">End Work</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" id="end_work"
                                                        name="end_work" />
                                                </div>
                                            </div>
                                            <div class="col-sm-offset-2 col-sm-10 mt-3">
                                                <button type="submit" class="btn btn-primary" id="btn-save"
                                                    value="addNewBook">Update Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        <!-- boostrap add and edit book model -->
                        <div class="modal fade modal-att" id="ajax-book-model-att" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="ajaxBookModelAtt">End Work Photo Information</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img class="form-control" src="" alt="" id="img-atts">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        @if (Auth::user()->dept == 'HR Legal')
                            <div class="card">
                                <div class="card">
                                    <form action="{{ route('user-import') }}" method="post"
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
                        @endif


                        <div class="card-body">
                            <a href="{{ route('add-emp') }}" class="btn btn-primary"><i
                                    class="fa-solid fa-plus"></i></a>
                            @if (Auth::user()->dept == 'HR Legal')
                                <a href="{{ route('employee-list-report') }}" class="btn btn-primary">EMPLOYEE LIST
                                    REPORT</a>
                                <a href="{{ route('enroll-data') }}" class="btn btn-primary">ENROLL DATA</a>
                                <a href="{{ route('enroll-data-contract') }}" class="btn btn-primary">ENROLL DATA
                                    CONTRACT</a>
                                    <a href="{{ route('master-jabatan') }}" class="btn btn-primary">MASTER JABATAN</a>
                            @endif
                            <div class="table-responsive p-0">
                                <table class="table table-striped table-sm align-items-center mb-0"
                                    id="table-attendance-now" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aktif
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Emp. Code</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Grade</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Dept.</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jabatan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kemandoran</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Sex</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                TTL</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Mulai Kerja</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Pendidikan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Agama</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Domisili</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Email</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No. KTP</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No. Telpon</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                KIS</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                KPJ</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Suku</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No. Sepatu Safety</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Start Work User</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                End Work User</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Lokasi Kerja</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Lokasi Absen</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Sistem Absen</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Latitude</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Longitude</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Status Pernikahan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Istri/Suami</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Anak 1</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Anak 2</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Anak 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr id="row_{{ $item->id }}">
                                                <td>
                                                    @if (Auth::user()->dept == 'HR Legal')
                                                        <a href="javascript:void(0);" id="delete"
                                                            onClick="deleteFunc({{ $item->id }})"
                                                            data-toggle="tooltip" data-original-title="Delete"
                                                            class="delete btn btn-danger"><i
                                                                class="fa-solid fa-trash"></i>
                                                        </a>
                                                        <a href="{{ route('view-emp', $item->id) }}"
                                                            class="btn btn-primary"><i
                                                                class="fa-solid fa-eye"></i></a>
                                                        <a href="{{ route('print-career-report', $item->nik) }}"
                                                            class="btn btn-info" target="_blank"><i
                                                                class="fa-solid fa-clock-rotate-left"></i></a>
                                                        <a href="{{ route('print-general-report', $item->nik) }}"
                                                            class="btn btn-primary" target="_blank"><i
                                                                class="fa-solid fa-print"></i></a>
                                                    @endif

                                                    <a href="{{ route('edit-emp', $item->id) }}"
                                                        class="btn btn-success"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>


                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="activeCheckbox"
                                                        name="activeCheckbox" id="activeCheckbox"
                                                        data-item-id="{{ $item->nik }}"
                                                        {{ ($item->active == 'yes') ? 'checked' : '' }}>
                                                </td>
                                                <td>{{ $item->nik }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>{{ $item->grade }}</td>
                                                <td>{{ $item->dept }}</td>
                                                <td>{{ $item->jabatan }}</td>
                                                <td>{{ $item->kemandoran }}</td>
                                                <td>{{ $item->sex }}</td>
                                                <td>{{ $item->ttl }}</td>
                                                <td>{{ $item->start }}</td>
                                                <td>{{ $item->pendidikan }}</td>
                                                <td>{{ $item->agama }}</td>
                                                <td>{{ $item->domisili }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->no_ktp }}</td>
                                                <td>{{ $item->no_telpon }}</td>
                                                <td>{{ $item->kis }}</td>
                                                <td>{{ $item->kpj }}</td>
                                                <td>{{ $item->suku }}</td>
                                                <td>{{ $item->no_sepatu_safety }}</td>
                                                <td>{{ $item->start_work_user }}</td>
                                                <td>{{ $item->end_work_user }}</td>
                                                <td>{{ $item->loc_kerja }}</td>
                                                <td>{{ $item->loc }}</td>
                                                <td>{{ $item->sistem_absensi }}</td>
                                                <td>{{ $item->latitude }}</td>
                                                <td>{{ $item->longitude }}</td>
                                                <td>{{ $item->status_pernikahan }}</td>
                                                <td>{{ $item->istri_suami }}</td>
                                                <td>{{ $item->anak_1 }}</td>
                                                <td>{{ $item->anak_2 }}</td>
                                                <td>{{ $item->anak_3 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
            $('#table-attendance-now').DataTable();
        });
    </script>
    <script>
        $(function() {

            $('*[name=start_work]').appendDtpicker();
            $('*[name=end_work]').appendDtpicker();

        });
    </script>
    <script>
            $('.activeCheckbox').change(function() {
                var isChecked = $(this).prop('checked');
                var nik = $(this).data('item-id');
                $.ajax({
                    type: "POST",
                    url: "{{ route('update-active') }}",
                    data: {
                        nik: nik,
                        isChecked: isChecked,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
    </script>
    <script type="text/javascript">
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
                        $('#row_' + id).remove();
                    }
                });
            }
        }
    </script>
</body>
