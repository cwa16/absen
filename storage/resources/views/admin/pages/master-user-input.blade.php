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
                                <h6 class="text-white text-capitalize ps-3">User - Input</h6>
                            </div>
                        </div>

                        <div class="card-body">
                          <div class="card">
                            <div class="card-body">
                              <form action="{{ route('update-user') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                  <label for="exampleFormControlInput1" class="form-label">Name</label>
                                  <select class="form-control" name="id" id="">
                                    <option value="" disabled selected>-- Pilih Karyawan --</option>
                                    @foreach ($user as $item)
                                      <option value="{{ $item->id }}">{{ $item->name }}</option>  
                                    @endforeach
                                  </select>
                                </div>

                                <div class="mb-3">
                                  <label for="exampleFormControlTextarea1" class="form-label">Role</label>
                                  <select class="form-control" name="role_app" id="">
                                    <option value="" disabled selected>-- Pilih Peran --</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                    <option value="Inputer">Inputer</option>
                                  </select>
                                </div>

                                <div class="mb-3">
                                  <label for="exampleFormControlTextarea1" class="form-label">Email</label>
                                  <input type="email" name="email" id="" class="form-control" placeholder="Masukan email">
                                </div>

                                <div class="mb-3">
                                  <label for="" class="form-label">Kata Sandi</label>
                                  <input class="form-control" type="password" name="password" id="" placeholder="masukan kata sandi">
                                </div>

                                <div class="mb-0">
                                  <button class="btn btn-primary form-control">Simpan</button>
                                </div>

                                <div class="mb-0">
                                  <button class="btn btn-secondary form-control">Kembali</button>
                                </div>

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
    <script>
        $(function() {

            $('*[name=start_work]').appendDtpicker();
            $('*[name=end_work]').appendDtpicker();

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#table-attendance-now').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user-master') }}",
                columns: [{
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role_app',
                        name: 'role_app'
                    },

                ]
            });
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
