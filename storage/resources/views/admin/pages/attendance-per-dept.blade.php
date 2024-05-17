@include('admin.includes.head')
<link rel="stylesheet" href="{{ 'https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' }}">

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
                                <h2 class="text-white text-capitalize ps-3">Laporan Kehadiran Per Departement</h2>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h1 class="mt-3">PT. Bridgestone Kalimantan Plantation</h1>
                                <div class="row mt-3">
                                    <div class="col">

                                        <form action="{{ route('summary-per-dept-filter') }}" method="POST">
                                            <div class="form-inline">

                                                @csrf
                                                <label for="">
                                                    <h4>Bulan:
                                                        {{ Carbon\Carbon::parse($monthLabel)->translatedformat('F Y') }}
                                                    </h4>
                                                </label>
                                                {{-- <select name="month" id="" class="form-control-sm">
                                                    <option value="01">Januari</option>
                                                    <option value="02">Februari</option>
                                                    <option value="03">Maret</option>
                                                    <option value="04">April</option>
                                                    <option value="05">Mei</option>
                                                    <option value="06">Juni</option>
                                                    <option value="07">Juli</option>
                                                    <option value="08">Agustus</option>
                                                    <option value="09">September</option>
                                                    <option value="10">Oktober</option>
                                                    <option value="11">November</option>
                                                    <option value="12">Desember</option>
                                                </select> --}}
                                                <input type="date" class="form-control form-control-sm"
                                                    name="month" id="">
                                                <button class="btn btn-primary btn-sm" style="margin-top:10px;" type="submit">Filter</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col">
                                    </div>
                                    <div class="col">
                                        <table class="table table-bordered border-warning">
                                            <thead>
                                                <tr>
                                                    <th class="text-center bg-warning">H</th>
                                                    <th>Hadir</th>
                                                    <th class="text-center bg-warning">I</th>
                                                    <th>Izin</th>
                                                    <th class="text-center bg-warning">IP</th>
                                                    <th>Izin Pribadi</th>
                                                    <th class="text-center bg-warning">IX</th>
                                                    <th>Izin Tidak Dibayar</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center bg-warning">L</th>
                                                    <th>Late (terlambat)</th>
                                                    <th class="text-center bg-warning">OT</th>
                                                    <th>Over Time (lembur)</th>
                                                    <th class="text-center bg-warning">S</th>
                                                    <th>Sakit</th>
                                                    <th class="text-center bg-warning">SX</th>
                                                    <th>Sakit Tidak Dibayar</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center bg-warning">CT</th>
                                                    <th>Cuti Tahunan</th>
                                                    <th class="text-center bg-warning">CB</th>
                                                    <th>Cuti Besar</th>
                                                    <th class="text-center bg-warning">CH</th>
                                                    <th>Cuti Melahirkan</th>
                                                    <th class="text-center bg-warning">CL</th>
                                                    <th>Cuti Lain-lain</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center bg-warning">M</th>
                                                    <th>Mangkir</th>
                                                    <th class="text-center bg-warning">MX</th>
                                                    <th>Mangkir Hari Libur</th>
                                                    <th class="text-center bg-warning">TA</th>
                                                    <th>Tidak Absen</th>
                                                    <th class="text-center bg-warning"></th>
                                                    <th></th>
                                                </tr>
                                                <tr></tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>



                                <div class="card-body px-0 pb-2" style="overflow-x:auto;">
                                    <table class="table table-striped table-bordered table-hover" id="myTablex">
                                        <thead>
                                            <tr>
                                                <th rowspan="4" class="align-middle">Kode Emp</th>
                                                <th rowspan="4" class="align-middle">Nama</th>
                                                <th rowspan="4" class="align-middle">Status</th>
                                                <th colspan="31" class="text-center">Tanggal</th>
                                                <th colspan="15" class="text-center">Keterangan</th>
                                            </tr>
                                            <tr>
                                                <th>1</th>
                                                <th>2</th>
                                                <th>3</th>
                                                <th>4</th>
                                                <th>5</th>
                                                <th>6</th>
                                                <th>7</th>
                                                <th>8</th>
                                                <th>9</th>
                                                <th>10</th>
                                                <th>11</th>
                                                <th>12</th>
                                                <th>13</th>
                                                <th>14</th>
                                                <th>15</th>
                                                <th>16</th>
                                                <th>17</th>
                                                <th>18</th>
                                                <th>19</th>
                                                <th>20</th>
                                                <th>21</th>
                                                <th>22</th>
                                                <th>23</th>
                                                <th>24</th>
                                                <th>25</th>
                                                <th>26</th>
                                                <th>27</th>
                                                <th>28</th>
                                                <th>29</th>
                                                <th>30</th>
                                                <th>31</th>
                                                <th rowspan="3" class="align-middle">H</th>
                                                <th rowspan="3" class="align-middle">L</th>
                                                <th rowspan="3" class="align-middle">TA</th>
                                                <th colspan="3" class="align-middle">I</th>
                                                <th colspan="2" class="align-middle">S</th>
                                                <th colspan="4" class="align-middle">C</th>
                                                <th rowspan="3" class="align-middle">TA</th>
                                            </tr>
                                            <tr>

                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-01')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-02')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-03')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-04')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-05')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-06')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-07')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-08')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-09')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-10')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-11')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-12')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-13')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-14')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-15')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-16')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-17')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-18')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-19')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-20')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-21')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-22')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-23')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-24')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-25')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-26')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-27')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-28')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-29')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-30')->translatedformat('l') }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse('' . $yearNow . '-' . $month . '-31')->translatedformat('l') }}
                                                </td>
                                                <td rowspan="1">I</td>
                                                <td rowspan="1">IP</td>
                                                <td rowspan="1">IX</td>
                                                <td rowspan="1">S</td>
                                                <td rowspan="1">SX</td>
                                                <td rowspan="1">CT</td>
                                                <td rowspan="1">CB</td>
                                                <td rowspan="1">CH</td>
                                                <td rowspan="1">CL</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($emp as $item => $users_list)
                                                <tr>
                                                    <th colspan="34">{{ $item }}</th>
                                                </tr>
                                                @foreach ($users_list->whereNotIn('status', ['Regular']) as $itemx)
                                                    <tr>
                                                        <td>{{ $itemx->nik }}</td>
                                                        <td>{{ $itemx->name }}</td>
                                                        <td>{{ $itemx->status }}</td>
                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 1)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 2)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 3)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 4)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 5)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 6)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 7)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 8)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 9)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 10)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 11)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 12)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 13)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 14)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 15)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 16)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 17)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 18)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 19)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 20)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 21)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 22)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 23)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 24)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 25)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 26)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 27)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 28)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 29)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 30)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            @foreach ($itemx->absen as $absens)
                                                                @if ($absens != null && Carbon\Carbon::parse($absens->date)->format('d') == 31)
                                                                    @switch($absens->desc)
                                                                        @case('sakit')
                                                                            S
                                                                        @break

                                                                        @case('izin')
                                                                            I
                                                                        @break

                                                                        @case('')
                                                                            H
                                                                        @break
                                                                    @endswitch
                                                                @endif
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', '')->count() }}
                                                        </td>

                                                        <td>{{ $itemx->absen->where('desc', 'L')->count() }}</td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', 'TA')->count() }}
                                                        </td>

                                                        <td>{{ $itemx->absen->where('desc', 'I')->count() }}</td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', 'IP')->count() }}
                                                        </td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', 'IX')->count() }}
                                                        </td>

                                                        <td>{{ $itemx->absen->whereNotNull('start_work_info_url')->where('desc', 'izin')->count() }}</td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', 'sakit')->count() }}
                                                        </td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', 'SX')->count() }}
                                                        </td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', 'cuti')->count() }}
                                                        </td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', 'CL')->count() }}
                                                        </td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', 'TA')->count() }}
                                                        </td>

                                                        <td>
                                                            {{ $itemx->absen->where('desc', 'TA')->count() }}
                                                        </td>


                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
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
