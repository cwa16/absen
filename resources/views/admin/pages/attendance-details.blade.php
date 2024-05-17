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
                                <h2 class="text-white text-capitalize ps-3">Laporan Kehadiran Detail</h2>
                            </div>
                        </div>

                        <div class="card">
                          <div class="card-body">
                            <h1 class="mt-3">PT. Bridgestone Kalimantan Plantation</h1>
                            <div class="row mt-3">
                              <div class="col">
  
                                <form action="{{ route('view-summary-emp-filter') }}" method="POST">
                                  <div class="form-inline">
                                   
                                      @csrf
                                      <label for=""><h3>Periode: </h3></label>
                                      <input type="hidden" name="id" value="{{ $emp->id }}">
                                      <input type="date" class="form-control-sm" name="from" id="">
                                      <input type="date" class="form-control-sm" name="to" id="">
                                      <button class="btn btn-primary btn-sm" type="submit">Filter</button>
                                   
                                  </div>
                                </form>
                                
                                <h3>Kode Emp: {{ $emp->nik }}</h3>
                                <h3 class="">Nama: {{ $emp->name }}</h3>
                                <h3>Status: {{ $emp->status }}</h3>
                                
                              </div>
                              <div class="col">
                                <h3>Dept: {{ $emp->dept }}</h3>
                                <h3>Jabatan: {{ $emp->jabatan }}</h3>
                              </div>
                              <div class="col">
                                <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th>H</th>
                                      <th>Hadir</th>
                                      <th>I</th>
                                      <th>Izin</th>
                                      <th>IX</th>
                                      <th>Izin Tidak Dibayar</th>
                                    </tr>
                                    <tr>
                                      <th>OT</th>
                                      <th>Over Time (lembur)</th>
                                      <th>S</th>
                                      <th>Sakit</th>
                                      <th>SX</th>
                                      <th>Sakit Tidak Dibayar</th>
                                    </tr>
                                    <tr>
                                      <th>D</th>
                                      <th>Dinas</th>
                                      <th>E</th>
                                      <th>Early (pulang cepat)</th>
                                      <th>C</th>
                                      <th>Cuti</th>
                                    </tr>
                                    <tr>
                                      <th>A</th>
                                      <th>Absent (mangkir)</th>
                                      <th>TA</th>
                                      <th>Tidak Absen</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
  
                         
  
                          <div class="card-body px-0 pb-2">
                              <table class="table table-striped table-bordered" id="myTable">
                                  <thead>
                                      <tr>
                                          <th>Tanggal</th>
                                          <th>Hari</th>
                                          <th>Shift</th>
                                          <th>Jam Kerja</th>
                                          <th>Jam Masuk</th>
                                          <th>Jam Keluar</th>
                                          <th>Total Jam Kerja</th>
                                          <th>OT</th>
                                          <th>L</th>
                                          <th>A</th>
                                          <th>I</th>
                                          <th>IX</th>
                                          <th>S</th>
                                          <th>SX</th>
                                          <th>C</th>
                                          <th>TA</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($emp1 as $item)
                                          <tr>
                                              <td>{{ Carbon\Carbon::parse($item->date)->format('d-M-Y') }}</td>
                                              <td>{{ Carbon\Carbon::parse($item->date)->translatedformat('l') }}</td>
                                              <td></td>
  
                                              <td>{{ Carbon\Carbon::parse($emp->start_work_user)->format('H:i:s') }} -
                                                  {{ Carbon\Carbon::parse($emp->end_work_user)->format('H:i:s') }}</td>
  
                                              <td>{{ Carbon\Carbon::parse($item->start_work)->format('H:i:s') }}</td>
  
                                              {{-- jam Keluar --}}
                                              @if ($item->end_work == null)
                                                  <td></td>
                                              @else
                                                  <td>{{ Carbon\Carbon::parse($item->end_work)->format('H:i:s') }}</td>
                                              @endif
  
                                              {{-- Total Jam Kerja --}}
                                              <td id="val">{{ number_format($item->result, 1) }}</td>
  
                                              {{-- OT --}}
                                              @if ($item->result > 8)
                                                  <td class="ot">
                                                      {{ number_format($item->result, 1) - number_format($item->userWork, 1) + 1 }}
                                                     
                                                  </td>
                                              @else
                                                  <td></td>
                                              @endif
  
                                              {{-- L --}}
                                              @if (Carbon\Carbon::parse($item->start_work)->format('H:i:s') >
                                                  Carbon\Carbon::parse($emp->start_work_user)->format('H:i:s'))
                                                  <td>I</td>
                                              @else
                                                  <td></td>
                                              @endif
  
                                              {{-- A --}}
                                              @if ($item->start_work == null)
                                                  <td>I</td>
                                              @else
                                                  <td></td>
                                              @endif
  
                                              {{-- I --}}
                                              @if ($item->desc == 'izin')
                                                  <td>I</td>
                                              @else
                                                  <td></td>
                                              @endif
  
                                              {{-- IX --}}
                                              @if ($item->desc != '')
                                                  <td>I</td>
                                              @else
                                                  <td></td>
                                              @endif
  
                                              {{-- S --}}
                                              @if ($item->desc == 'sakit')
                                                  <td>I</td>
                                              @else
                                                  <td></td>
                                              @endif
  
                                              {{-- SX --}}
                                              @if ($item->desc == 'sakit')
                                                  <td>I</td>
                                              @else
                                                  <td></td>
                                              @endif
  
                                              {{-- C --}}
                                              @if ($item->desc == 'cuti')
                                                  <td>I</td>
                                              @else
                                                  <td></td>
                                              @endif
  
                                              {{-- TA --}}
                                              @if ($item->start_work == null)
                                                  <td>I</td>
                                              @else
                                                  <td></td>
                                              @endif
  
                                          </tr>
                                      @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <td colspan="5">Total Hari: {{ $emp->absen->count() }}</td>
                                          <td>{{ number_format($totalHours, 1) }} Jam</td>
                                          <td>{{ number_format($rr,1) }} Jam</td>
                                      </tr>
                                  </tfoot>
                              </table>
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
   
</body>
