@include('admin.includes.head')
<style>
    #table-data th,
    #table-data td {
        border: 1px solid #282d3a;
        padding: 3px;
        text-align: center;
    }

    #table-data thead {
        background-color: #f2f0e9;
    }

    #table-data th {
        background-color: #f2f0e9;
        border: 1px solid #282d3a;
    }

    #table-data tbody tr:nth-child(even) {
        background-color: #f2f2f2;
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
                                <h6 class="text-white text-capitalize ps-3">Kehadiran Karyawan Per Dept</h6>
                            </div>
                        </div>
                        <div class="card mx-3 my-3">
                                    <div class="">
                                        <div class="">
                                            <div class="card-header">
                                                <h3><strong>Kehadiran Karyawan Per Dept</strong></h3>
                                            </div>
                                            <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h4>Dept: {{ $dept }}</h4>
                                                            <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                        </div>
                                                        <div class="col-md-6 text-md-end">
                                                            <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                            <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                            <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                        </div>
                                                    </div>
                                                    <table id="table-data">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                                <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Status</th>
                                                                <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total<br>TK</th>
                                                                <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Hadir<br>(H)</th>
                                                                <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">TA</th>
                                                                <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Dinas<br>(D)</th>
                                                                <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Lambat<br>(L)<br>Day</th>
                                                                <th colspan="2">Mangkir (M)</th>
                                                                <th colspan="2">Sakit (S)</th>
                                                                <th colspan="3">Ijin (I)</th>
                                                                <th colspan="4">Cuti (C)</th>
                                                            </tr>
                                                            <tr>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">M</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">MX</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">S</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">SX</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">I</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">IP</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">IX</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">CT</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">CH</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">CB</th>
                                                                <th style="text-align: center; vertical-align: middle;width: 77px;">CL</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            <tr>
                                                                <td>1</td>
                                                                <td class="text-left">Staff</td>
                                                                <td>{{ $staffTotal }}</td>
                                                            @if($staffAtt->isEmpty())
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                            @else
                                                                @foreach ($staffAtt as $staff)
                                                                    <td>{{ $staff->h }}</td>
                                                                    <td>{{ $staff->ta }}</td>
                                                                    <td>{{ $staff->d }}</td>
                                                                    <td>{{ $staff->l }}</td>
                                                                    <td>{{ $staff->m }}</td>
                                                                    <td>{{ $staff->mx }}</td>
                                                                    <td>{{ $staff->s }}</td>
                                                                    <td>{{ $staff->sx }}</td>
                                                                    <td>{{ $staff->i }}</td>
                                                                    <td>{{ $staff->ip }}</td>
                                                                    <td>{{ $staff->ix }}</td>
                                                                    <td>{{ $staff->ct }}</td>
                                                                    <td>{{ $staff->ch }}</td>
                                                                    <td>{{ $staff->cb }}</td>
                                                                    <td>{{ $staff->cl }}</td>
                                                                @endforeach
                                                            @endif
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td class="text-left">Monthly</td>
                                                                <td>{{ $monthlyTotal }}</td>
                                                            @if($monAtt->isEmpty())
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                            @else
                                                                @foreach ($monAtt as $mon)
                                                                    <td>{{ $mon->h }}</td>
                                                                    <td>{{ $mon->ta }}</td>
                                                                    <td>{{ $mon->d }}</td>
                                                                    <td>{{ $mon->l }}</td>
                                                                    <td>{{ $mon->m }}</td>
                                                                    <td>{{ $mon->mx }}</td>
                                                                    <td>{{ $mon->s }}</td>
                                                                    <td>{{ $mon->sx }}</td>
                                                                    <td>{{ $mon->i }}</td>
                                                                    <td>{{ $mon->ip }}</td>
                                                                    <td>{{ $mon->ix }}</td>
                                                                    <td>{{ $mon->ct }}</td>
                                                                    <td>{{ $mon->ch }}</td>
                                                                    <td>{{ $mon->cb }}</td>
                                                                    <td>{{ $mon->cl }}</td>
                                                                @endforeach
                                                            @endif

                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td class="text-left">Regular</td>
                                                                <td>{{ $regularTotal }}</td>
                                                            @if($regAtt->isEmpty())
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                            @else
                                                                @foreach ($regAtt as $reg)
                                                                    <td>{{ $reg->h }}</td>
                                                                    <td>{{ $reg->ta }}</td>
                                                                    <td>{{ $reg->d }}</td>
                                                                    <td>{{ $reg->l }}</td>
                                                                    <td>{{ $reg->m }}</td>
                                                                    <td>{{ $reg->mx }}</td>
                                                                    <td>{{ $reg->s }}</td>
                                                                    <td>{{ $reg->sx }}</td>
                                                                    <td>{{ $reg->i }}</td>
                                                                    <td>{{ $reg->ip }}</td>
                                                                    <td>{{ $reg->ix }}</td>
                                                                    <td>{{ $reg->ct }}</td>
                                                                    <td>{{ $reg->ch }}</td>
                                                                    <td>{{ $reg->cb }}</td>
                                                                    <td>{{ $reg->cl }}</td>
                                                                @endforeach
                                                            @endif
                                                            </tr>
                                                            <tr>
                                                                <td>4</td>
                                                                <td class="text-left">Contract BSKP</td>
                                                                <td>{{ $bskpTotal }}</td>
                                                            @if($bskpAtt->isEmpty())
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                            @else
                                                                @foreach ($bskpAtt as $bskp)
                                                                    <td>{{ $bskp->h }}</td>
                                                                    <td>{{ $bskp->ta }}</td>
                                                                    <td>{{ $bskp->d }}</td>
                                                                    <td>{{ $bskp->l }}</td>
                                                                    <td>{{ $bskp->m }}</td>
                                                                    <td>{{ $bskp->mx }}</td>
                                                                    <td>{{ $bskp->s }}</td>
                                                                    <td>{{ $bskp->sx }}</td>
                                                                    <td>{{ $bskp->i }}</td>
                                                                    <td>{{ $bskp->ip }}</td>
                                                                    <td>{{ $bskp->ix }}</td>
                                                                    <td>{{ $bskp->ct }}</td>
                                                                    <td>{{ $bskp->ch }}</td>
                                                                    <td>{{ $bskp->cb }}</td>
                                                                    <td>{{ $bskp->cl }}</td>
                                                                @endforeach
                                                            @endif
                                                            </tr>
                                                            <tr>
                                                                <td>5</td>
                                                                <td class="text-left">Contract FL</td>
                                                                <td>{{ $flTotal }}</td>
                                                            @if($flAtt->isEmpty())
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                            @else
                                                                @foreach ($flAtt as $fl)
                                                                    <td>{{ $fl->h }}</td>
                                                                    <td>{{ $fl->ta }}</td>
                                                                    <td>{{ $fl->d }}</td>
                                                                    <td>{{ $fl->l }}</td>
                                                                    <td>{{ $fl->m }}</td>
                                                                    <td>{{ $fl->mx }}</td>
                                                                    <td>{{ $fl->s }}</td>
                                                                    <td>{{ $fl->sx }}</td>
                                                                    <td>{{ $fl->i }}</td>
                                                                    <td>{{ $fl->ip }}</td>
                                                                    <td>{{ $fl->ix }}</td>
                                                                    <td>{{ $fl->ct }}</td>
                                                                    <td>{{ $fl->ch }}</td>
                                                                    <td>{{ $fl->cb }}</td>
                                                                    <td>{{ $fl->cl }}</td>
                                                                @endforeach
                                                            @endif
                                                            </tr>
                                                            <tr></tr>
                                                        </tbody>
                                                        <tfoot class="text-center">
                                                            <tr style="background-color: #ffff99;">
                                                                <td></td>
                                                                <td class="text-left">Total</td>
                                                                <td>{{ $staffTotal + $monthlyTotal + $regularTotal + $flTotal + $bskpTotal }}</td>
                                                                <td>{{ $totalHFinal }}</td>
                                                                <td>{{ $totalTAFinal }}</td>
                                                                <td>{{ $totalDFinal }}</td>
                                                                <td>{{ $totalLFinal }}</td>
                                                                <td>{{ $totalMFinal }}</td>
                                                                <td>{{ $totalMXFinal }}</td>
                                                                <td>{{ $totalSFinal }}</td>
                                                                <td>{{ $totalSXFinal }}</td>
                                                                <td>{{ $totalIFinal }}</td>
                                                                <td>{{ $totalIPFinal }}</td>
                                                                <td>{{ $totalIXFinal }}</td>
                                                                <td>{{ $totalCTFinal }}</td>
                                                                <td>{{ $totalCHFinal }}</td>
                                                                <td>{{ $totalCBFinal }}</td>
                                                                <td>{{ $totalCLFinal }}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
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
</body>
