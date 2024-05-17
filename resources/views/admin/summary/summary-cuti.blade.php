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
                                <h6 class="text-white text-capitalize ps-3">Summary Cuti</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row">
                                <div class="col">
                                    <div class="card mx-2">
                                        <div class="card-body">
                                            <form class="input-group" action="{{ route('load-summary-cuti') }}"
                                                method="post">
                                                @csrf
                                                <input type="month" name="date" id=""
                                                    class="form-control" required>
                                                <select name="group" id="" class="form-control" required>
                                                    <option value="" selected disabled>-- Pilih Group --</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Dept">Depart</option>
                                                </select>
                                                <button class="btn btn-primary">Load</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($data != null)
                            <div class="row mt-2">
                              <div class="col">
                                  <div class="card mx-2">
                                      <div class="card-body">
                                          <table
                                              class="table table-bordered table-striped table-responsive table-hover">
                                              <thead>
                                                  <tr class="align-middle text-center">
                                                      <th rowspan="2">NIK</th>
                                                      <th rowspan="2">Employee Name</th>
                                                      <th colspan="5">Budget Kind Of Leave</th>
                                                      <th colspan="5">Actual Kind Of Leave</th>
                                                      <th rowspan="2">Balance</th>
                                                      <th rowspan="2">Departement</th>
                                                  </tr>
                                                  <tr class="align-middle">
                                                      <th>Large</th>
                                                      <th>Yearly</th>
                                                      <th>Sick</th>
                                                      <th>Birth</th>
                                                      <th>Other</th>
                                                      <th>Large</th>
                                                      <th>Yearly</th>
                                                      <th>Sick</th>
                                                      <th>Birth</th>
                                                      <th>Other</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @foreach ($data as $item => $item_list)
                                                      <tr>
                                                        <th colspan="14" style="background-color: rgb(255, 191, 0)"><strong>{{ $item }}</strong></th>
                                                      </tr>
                                                     @foreach ($item_list as $itemx)
                                                     <tr>
                                                      <td>{{ $itemx->nik }}</td>
                                                      <td>{{ $itemx->name }}</td>
                                                      <td>{{ $CB_budget }}</td>
                                                      <td>{{ $CT_budget }}</td>
                                                      <td>{{ $CS_budget }}</td>
                                                      <td>{{ $CH_budget }}</td>
                                                      <td>{{ $CLL_budget }}</td>
                                                      @if ($itemx->kind == 'Large')
                                                          <td>{{ $itemx->total }}</td>
                                                      @else
                                                          <td>0</td>
                                                      @endif

                                                      @if ($itemx->kind == 'Yearly')
                                                          <td>{{ $itemx->total }}</td>
                                                      @else
                                                          <td>0</td>
                                                      @endif

                                                      @if ($itemx->kind == 'Sick')
                                                          <td>{{ $itemx->total }}</td>
                                                      @else
                                                          <td>0</td>
                                                      @endif

                                                      @if ($itemx->kind == 'Birth')
                                                          <td>{{ $itemx->total }}</td>
                                                      @else
                                                          <td>0</td>
                                                      @endif

                                                      @if ($itemx->kind == 'Other')
                                                          <td>{{ $itemx->total }}</td>
                                                      @else
                                                          <td>0</td>
                                                      @endif

                                                      <td>{{ $total_budget-$itemx->total }}</td>
                                                      <td>{{ $itemx->dept }}</td>
                                                  </tr>
                                                     @endforeach
                                                  @endforeach
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                          </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
    <script type="text/javascript">
        $(function() {

            var table = $('#table-attendance-now').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('attendance-summary') }}",
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
                    {
                        data: 'approval_by',
                        name: 'approval_by'
                    },
                    {
                        data: 'checked_by',
                        name: 'checked_by'
                    }
                ]
            });

        });
    </script>
</body>
