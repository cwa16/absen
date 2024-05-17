@include('admin.includes.head')

<body class="g-sidenav-show bg-gray-200">
  @include('admin.layouts.sidenav')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" >
    @include('admin.layouts.navbar')
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Attendance Table - Summary</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table table-striped table-sm align-items-center mb-0" id="table-attendance-now" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Emp Code</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dept</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jabatan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                    </tr>
                  </thead>
                  <tbody> 
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
  <script type="text/javascript">
    $(function () {
      
      var table = $('#table-attendance-now').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('summary-per-emp') }}",
          columns: [
              {data: 'nik', name: 'nik'},
              {data: 'name', name: 'name'},
              {data: 'status', name: 'status'},
              {data: 'dept', name: 'dept'},
              {data: 'jabatan', name: 'jabatan'},
              {data: 'action', name: 'action'}
          ]
      });
      
    });
  </script>
</body>

