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
                                <h3 class="text-white text-capitalize ps-3"><strong>Dashboard Summary Kehadiran</strong></h3>
                            </div>
                        </div>

                        {{-- I/A --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: I/A</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalA }}</td>
                                                        @if($staffAttA->isEmpty())
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
                                                        @foreach ($staffAttA as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalA }}</td>
                                                        @if($monAttA->isEmpty())
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
                                                        @foreach ($monAttA as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalA }}</td>
                                                        @if($regAttA->isEmpty())
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
                                                        @foreach ($regAttA as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalA }}</td>
                                                        @if($bskpAttA->isEmpty())
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
                                                        @foreach ($bskpAttA as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalA }}</td>
                                                        @if($flAttA->isEmpty())
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
                                                        @foreach ($flAttA as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalA + $monthlyTotalA + $regularTotalA + $bskpTotalA + $flTotalA }}</td>
                                                        <td>{{ $totalHFinalA }}</td>
                                                        <td>{{ $totalTAFinalA }}</td>
                                                        <td>{{ $totalDFinalA }}</td>
                                                        <td>{{ $totalLFinalA }}</td>
                                                        <td>{{ $totalMFinalA }}</td>
                                                        <td>{{ $totalMXFinalA }}</td>
                                                        <td>{{ $totalSFinalA }}</td>
                                                        <td>{{ $totalSXFinalA }}</td>
                                                        <td>{{ $totalIFinalA }}</td>
                                                        <td>{{ $totalIPFinalA }}</td>
                                                        <td>{{ $totalIXFinalA }}</td>
                                                        <td>{{ $totalCTFinalA }}</td>
                                                        <td>{{ $totalCHFinalA }}</td>
                                                        <td>{{ $totalCBFinalA }}</td>
                                                        <td>{{ $totalCLFinalA }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttA as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->h }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hA }}</td>
                                                        <td>{{ $total_taA }}</td>
                                                        <td>{{ $total_dA }}</td>
                                                        <td>{{ $total_lA }}</td>
                                                        <td>{{ $total_mA }}</td>
                                                        <td>{{ $total_mxA }}</td>
                                                        <td>{{ $total_sA }}</td>
                                                        <td>{{ $total_sxA }}</td>
                                                        <td>{{ $total_iA }}</td>
                                                        <td>{{ $total_ipA }}</td>
                                                        <td>{{ $total_ixA }}</td>
                                                        <td>{{ $total_ctA }}</td>
                                                        <td>{{ $total_chA }}</td>
                                                        <td>{{ $total_cbA }}</td>
                                                        <td>{{ $total_clA }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>3. Data Kehadiran Perkemandoran</h4>
                                            <table class="table" id="table-data">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Mandor</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Status</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Total<br>TK</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="padding-left:8px;padding-right:8px;width: 80px;">TA</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">M</th>
                                                        <th style="width: 80px;">MX</th>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">S</th>
                                                        <th style="width: 80px;">SX</th>
                                                        <th style="padding-left:16px;padding-right:16px;width: 80px;">I</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IP</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IX</th>
                                                        <th style="width: 80px;">CT</th>
                                                        <th style="width: 80px;">CH</th>
                                                        <th style="width: 80px;">CB</th>
                                                        <th style="width: 80px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($dataA as $item)
                                                        <tr class="text-left">
                                                            <td rowspan="4" style="text-align: center; vertical-align: middle;">{{ $counter++ }}</td>
                                                            <form action="{{ route('summary-per-dept-mandor-per-emp-for-dash') }}" method="POST">
                                                                @csrf
                                                                <td rowspan="4" class="text-left">
                                                                    <br>
                                                                    <input type="hidden" name="mandor_nik" value="{{ $item['mandor'] }}">
                                                                    <input type="hidden" name="date" value="{{ $item['date'] }}">
                                                                    <input type="hidden" name="dept" value="{{ $item['dept'] }}">
                                                                    {{ $item['mandorName'] }}
                                                                    <br><button class="btn btn-primary btn-sm" type="submit">Detail</button>
                                                                </td>
                                                            </form>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">Reg</td>
                                                            <td>{{ $item['regularTotal1A'] }}</td>
                                                            <td>{{ $item['totalHFinalRegA'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegA'] }}</td>
                                                            <td>{{ $item['totalDFinalRegA'] }}</td>
                                                            <td>{{ $item['totalLFinalRegA'] }}</td>
                                                            <td>{{ $item['totalMFinalRegA'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegA'] }}</td>
                                                            <td>{{ $item['totalSFinalRegA'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegA'] }}</td>
                                                            <td>{{ $item['totalIFinalRegA'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegA'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegA'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegA'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegA'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegA'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegA'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">FL</td>
                                                            <td>{{ $item['flTotal1A'] }}</td>
                                                            <td>{{ $item['totalHFinalFlA'] }}</td>
                                                            <td>{{ $item['totalTAFinalFlA'] }}</td>
                                                            <td>{{ $item['totalDFinalFlA'] }}</td>
                                                            <td>{{ $item['totalLFinalFlA'] }}</td>
                                                            <td>{{ $item['totalMFinalFlA'] }}</td>
                                                            <td>{{ $item['totalMXFinalFlA'] }}</td>
                                                            <td>{{ $item['totalSFinalFlA'] }}</td>
                                                            <td>{{ $item['totalSXFinalFlA'] }}</td>
                                                            <td>{{ $item['totalIFinalFlA'] }}</td>
                                                            <td>{{ $item['totalIPFinalFlA'] }}</td>
                                                            <td>{{ $item['totalIXFinalFlA'] }}</td>
                                                            <td>{{ $item['totalCTFinalFlA'] }}</td>
                                                            <td>{{ $item['totalCHFinalFlA'] }}</td>
                                                            <td>{{ $item['totalCBFinalFlA'] }}</td>
                                                            <td>{{ $item['totalCLFinalFlA'] }}</td>
                                                        </tr>
                                                        <tr style="background-color: #ffff99;">
                                                            <td class="text-left text-bold">Total</td>
                                                            <td>{{ $item['regularTotal1A'] + $item['flTotal1A'] }}</td>
                                                            <td>{{ $item['totalHFinalRegA'] + $item['totalHFinalFlA'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegA'] + $item['totalTAFinalFlA'] }}</td>
                                                            <td>{{ $item['totalDFinalRegA'] + $item['totalDFinalFlA'] }}</td>
                                                            <td>{{ $item['totalLFinalRegA'] + $item['totalLFinalFlA'] }}</td>
                                                            <td>{{ $item['totalMFinalRegA'] + $item['totalMFinalFlA'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegA'] + $item['totalMXFinalFlA'] }}</td>
                                                            <td>{{ $item['totalSFinalRegA'] + $item['totalSFinalFlA'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegA'] + $item['totalSXFinalFlA'] }}</td>
                                                            <td>{{ $item['totalIFinalRegA'] + $item['totalIFinalFlA'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegA'] + $item['totalIPFinalFlA'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegA'] + $item['totalIXFinalFlA'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegA'] + $item['totalCTFinalFlA'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegA'] + $item['totalCHFinalFlA'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegA'] + $item['totalCBFinalFlA'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegA'] + $item['totalCLFinalFlA'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td rowspan="4"></td>
                                                        <td rowspan="4" style="text-align: center; vertical-align: middle;">Total</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">Reg</td>
                                                        <td>{{ $totalRegularTotal1A }}</td>
                                                        <td>{{ $totalHTotalRegA }}</td>
                                                        <td>{{ $totalTATotalRegA }}</td>
                                                        <td>{{ $totalDTotalRegA }}</td>
                                                        <td>{{ $totalLTotalRegA }}</td>
                                                        <td>{{ $totalMTotalRegA }}</td>
                                                        <td>{{ $totalMXTotalRegA }}</td>
                                                        <td>{{ $totalSTotalRegA }}</td>
                                                        <td>{{ $totalSXTotalRegA }}</td>
                                                        <td>{{ $totalITotalRegA }}</td>
                                                        <td>{{ $totalIPTotalRegA }}</td>
                                                        <td>{{ $totalIXTotalRegA }}</td>
                                                        <td>{{ $totalCTTotalRegA }}</td>
                                                        <td>{{ $totalCHTotalRegA }}</td>
                                                        <td>{{ $totalCBTotalRegA }}</td>
                                                        <td>{{ $totalCLTotalRegA }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">FL</td>
                                                        <td>{{ $totalFlTotal1A }}</td>
                                                        <td>{{ $totalHTotalFlA }}</td>
                                                        <td>{{ $totalTATotalFlA }}</td>
                                                        <td>{{ $totalDTotalFlA }}</td>
                                                        <td>{{ $totalLTotalFlA }}</td>
                                                        <td>{{ $totalMTotalFlA }}</td>
                                                        <td>{{ $totalMXTotalFlA }}</td>
                                                        <td>{{ $totalSTotalFlA }}</td>
                                                        <td>{{ $totalSXTotalFlA }}</td>
                                                        <td>{{ $totalITotalFlA }}</td>
                                                        <td>{{ $totalIPTotalFlA }}</td>
                                                        <td>{{ $totalIXTotalFlA }}</td>
                                                        <td>{{ $totalCTTotalFlA }}</td>
                                                        <td>{{ $totalCHTotalFlA }}</td>
                                                        <td>{{ $totalCBTotalFlA }}</td>
                                                        <td>{{ $totalCLTotalFlA }}</td>
                                                    </tr>
                                                    <tr style="background-color: #ffff99;">
                                                        <td class="text-left text-bold">Total</td>
                                                        <td>{{ $totalRegularTotal1A + $totalFlTotal1A }}</td>
                                                        <td>{{ $totalHTotalRegA + $totalHTotalFlA }}</td>
                                                        <td>{{ $totalTATotalRegA + $totalTATotalFlA }}</td>
                                                        <td>{{ $totalDTotalRegA + $totalDTotalFlA }}</td>
                                                        <td>{{ $totalLTotalRegA + $totalLTotalFlA }}</td>
                                                        <td>{{ $totalMTotalRegA + $totalMTotalFlA }}</td>
                                                        <td>{{ $totalMXTotalRegA + $totalMXTotalFlA }}</td>
                                                        <td>{{ $totalSTotalRegA + $totalSTotalFlA }}</td>
                                                        <td>{{ $totalSXTotalRegA + $totalSXTotalFlA }}</td>
                                                        <td>{{ $totalITotalRegA + $totalITotalFlA }}</td>
                                                        <td>{{ $totalIPTotalRegA + $totalIPTotalFlA }}</td>
                                                        <td>{{ $totalIXTotalRegA + $totalIXTotalFlA }}</td>
                                                        <td>{{ $totalCTTotalRegA + $totalCTTotalFlA }}</td>
                                                        <td>{{ $totalCHTotalRegA + $totalCHTotalFlA }}</td>
                                                        <td>{{ $totalCBTotalRegA + $totalCBTotalFlA }}</td>
                                                        <td>{{ $totalCLTotalRegA + $totalCLTotalFlA }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>

                        {{-- I/B --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: I/B</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalB }}</td>
                                                        @if($staffAttB->isEmpty())
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
                                                        @foreach ($staffAttB as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalB }}</td>
                                                        @if($monAttB->isEmpty())
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
                                                        @foreach ($monAttB as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalB }}</td>
                                                        @if($regAttB->isEmpty())
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
                                                        @foreach ($regAttB as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalB }}</td>
                                                        @if($bskpAttB->isEmpty())
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
                                                        @foreach ($bskpAttB as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalB }}</td>
                                                        @if($flAttB->isEmpty())
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
                                                        @foreach ($flAttB as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalB + $monthlyTotalB + $regularTotalB + $bskpTotalB + $flTotalB }}</td>
                                                        <td>{{ $totalHFinalB }}</td>
                                                        <td>{{ $totalTAFinalB }}</td>
                                                        <td>{{ $totalDFinalB }}</td>
                                                        <td>{{ $totalLFinalB }}</td>
                                                        <td>{{ $totalMFinalB }}</td>
                                                        <td>{{ $totalMXFinalB }}</td>
                                                        <td>{{ $totalSFinalB }}</td>
                                                        <td>{{ $totalSXFinalB }}</td>
                                                        <td>{{ $totalIFinalB }}</td>
                                                        <td>{{ $totalIPFinalB }}</td>
                                                        <td>{{ $totalIXFinalB }}</td>
                                                        <td>{{ $totalCTFinalB }}</td>
                                                        <td>{{ $totalCHFinalB }}</td>
                                                        <td>{{ $totalCBFinalB }}</td>
                                                        <td>{{ $totalCLFinalB }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttB as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hB }}</td>
                                                        <td>{{ $total_taB }}</td>
                                                        <td>{{ $total_dB }}</td>
                                                        <td>{{ $total_lB }}</td>
                                                        <td>{{ $total_mB }}</td>
                                                        <td>{{ $total_mxB }}</td>
                                                        <td>{{ $total_sB }}</td>
                                                        <td>{{ $total_sxB }}</td>
                                                        <td>{{ $total_iB }}</td>
                                                        <td>{{ $total_ipB }}</td>
                                                        <td>{{ $total_ixB }}</td>
                                                        <td>{{ $total_ctB }}</td>
                                                        <td>{{ $total_chB }}</td>
                                                        <td>{{ $total_cbB }}</td>
                                                        <td>{{ $total_clB }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>3. Data Kehadiran Perkemandoran</h4>
                                            <table class="table" id="table-data">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Mandor</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Status</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Total<br>TK</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="padding-left:8px;padding-right:8px;width: 80px;">TA</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">M</th>
                                                        <th style="width: 80px;">MX</th>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">S</th>
                                                        <th style="width: 80px;">SX</th>
                                                        <th style="padding-left:16px;padding-right:16px;width: 80px;">I</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IP</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IX</th>
                                                        <th style="width: 80px;">CT</th>
                                                        <th style="width: 80px;">CH</th>
                                                        <th style="width: 80px;">CB</th>
                                                        <th style="width: 80px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($data as $item)
                                                        <tr class="text-left">
                                                            <td rowspan="4" style="text-align: center; vertical-align: middle;">{{ $counter++ }}</td>
                                                            <form action="{{ route('summary-per-dept-mandor-per-emp-for-dash') }}" method="POST">
                                                                @csrf
                                                                <td rowspan="4" class="text-left">
                                                                    <br>
                                                                    <input type="hidden" name="mandor_nik" value="{{ $item['mandorB'] }}">
                                                                    <input type="hidden" name="date" value="{{ $item['date'] }}">
                                                                    <input type="hidden" name="dept" value="I/B">
                                                                    {{ $item['mandorName'] }}
                                                                    <br><button class="btn btn-primary btn-sm" type="submit">Detail</button>
                                                                </td>
                                                            </form>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">Reg</td>
                                                            <td>{{ $item['regularTotal1'] }}</td>
                                                            <td>{{ $item['totalHFinalReg'] }}</td>
                                                            <td>{{ $item['totalTAFinalReg'] }}</td>
                                                            <td>{{ $item['totalDFinalReg'] }}</td>
                                                            <td>{{ $item['totalLFinalReg'] }}</td>
                                                            <td>{{ $item['totalMFinalReg'] }}</td>
                                                            <td>{{ $item['totalMXFinalReg'] }}</td>
                                                            <td>{{ $item['totalSFinalReg'] }}</td>
                                                            <td>{{ $item['totalSXFinalReg'] }}</td>
                                                            <td>{{ $item['totalIFinalReg'] }}</td>
                                                            <td>{{ $item['totalIPFinalReg'] }}</td>
                                                            <td>{{ $item['totalIXFinalReg'] }}</td>
                                                            <td>{{ $item['totalCTFinalReg'] }}</td>
                                                            <td>{{ $item['totalCHFinalReg'] }}</td>
                                                            <td>{{ $item['totalCBFinalReg'] }}</td>
                                                            <td>{{ $item['totalCLFinalReg'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">FL</td>
                                                            <td>{{ $item['flTotal1'] }}</td>
                                                            <td>{{ $item['totalHFinalFl'] }}</td>
                                                            <td>{{ $item['totalTAFinalFl'] }}</td>
                                                            <td>{{ $item['totalDFinalFl'] }}</td>
                                                            <td>{{ $item['totalLFinalFl'] }}</td>
                                                            <td>{{ $item['totalMFinalFl'] }}</td>
                                                            <td>{{ $item['totalMXFinalFl'] }}</td>
                                                            <td>{{ $item['totalSFinalFl'] }}</td>
                                                            <td>{{ $item['totalSXFinalFl'] }}</td>
                                                            <td>{{ $item['totalIFinalFl'] }}</td>
                                                            <td>{{ $item['totalIPFinalFl'] }}</td>
                                                            <td>{{ $item['totalIXFinalFl'] }}</td>
                                                            <td>{{ $item['totalCTFinalFl'] }}</td>
                                                            <td>{{ $item['totalCHFinalFl'] }}</td>
                                                            <td>{{ $item['totalCBFinalFl'] }}</td>
                                                            <td>{{ $item['totalCLFinalFl'] }}</td>
                                                        </tr>
                                                        <tr style="background-color: #ffff99;">
                                                            <td class="text-left text-bold">Total</td>
                                                            <td>{{ $item['regularTotal1'] + $item['flTotal1'] }}</td>
                                                            <td>{{ $item['totalHFinalReg'] + $item['totalHFinalFl'] }}</td>
                                                            <td>{{ $item['totalTAFinalReg'] + $item['totalTAFinalFl'] }}</td>
                                                            <td>{{ $item['totalDFinalReg'] + $item['totalDFinalFl'] }}</td>
                                                            <td>{{ $item['totalLFinalReg'] + $item['totalLFinalFl'] }}</td>
                                                            <td>{{ $item['totalMFinalReg'] + $item['totalMFinalFl'] }}</td>
                                                            <td>{{ $item['totalMXFinalReg'] + $item['totalMXFinalFl'] }}</td>
                                                            <td>{{ $item['totalSFinalReg'] + $item['totalSFinalFl'] }}</td>
                                                            <td>{{ $item['totalSXFinalReg'] + $item['totalSXFinalFl'] }}</td>
                                                            <td>{{ $item['totalIFinalReg'] + $item['totalIFinalFl'] }}</td>
                                                            <td>{{ $item['totalIPFinalReg'] + $item['totalIPFinalFl'] }}</td>
                                                            <td>{{ $item['totalIXFinalReg'] + $item['totalIXFinalFl'] }}</td>
                                                            <td>{{ $item['totalCTFinalReg'] + $item['totalCTFinalFl'] }}</td>
                                                            <td>{{ $item['totalCHFinalReg'] + $item['totalCHFinalFl'] }}</td>
                                                            <td>{{ $item['totalCBFinalReg'] + $item['totalCBFinalFl'] }}</td>
                                                            <td>{{ $item['totalCLFinalReg'] + $item['totalCLFinalFl'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td rowspan="4"></td>
                                                        <td rowspan="4" style="text-align: center; vertical-align: middle;">Total</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">Reg</td>
                                                        <td>{{ $totalRegularTotal1 }}</td>
                                                        <td>{{ $totalHTotalReg }}</td>
                                                        <td>{{ $totalTATotalReg }}</td>
                                                        <td>{{ $totalDTotalReg }}</td>
                                                        <td>{{ $totalLTotalReg }}</td>
                                                        <td>{{ $totalMTotalReg }}</td>
                                                        <td>{{ $totalMXTotalReg }}</td>
                                                        <td>{{ $totalSTotalReg }}</td>
                                                        <td>{{ $totalSXTotalReg }}</td>
                                                        <td>{{ $totalITotalReg }}</td>
                                                        <td>{{ $totalIPTotalReg }}</td>
                                                        <td>{{ $totalIXTotalReg }}</td>
                                                        <td>{{ $totalCTTotalReg }}</td>
                                                        <td>{{ $totalCHTotalReg }}</td>
                                                        <td>{{ $totalCBTotalReg }}</td>
                                                        <td>{{ $totalCLTotalReg }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">FL</td>
                                                        <td>{{ $totalFlTotal1 }}</td>
                                                        <td>{{ $totalHTotalFl }}</td>
                                                        <td>{{ $totalTATotalFl }}</td>
                                                        <td>{{ $totalDTotalFl }}</td>
                                                        <td>{{ $totalLTotalFl }}</td>
                                                        <td>{{ $totalMTotalFl }}</td>
                                                        <td>{{ $totalMXTotalFl }}</td>
                                                        <td>{{ $totalSTotalFl }}</td>
                                                        <td>{{ $totalSXTotalFl }}</td>
                                                        <td>{{ $totalITotalFl }}</td>
                                                        <td>{{ $totalIPTotalFl }}</td>
                                                        <td>{{ $totalIXTotalFl }}</td>
                                                        <td>{{ $totalCTTotalFl }}</td>
                                                        <td>{{ $totalCHTotalFl }}</td>
                                                        <td>{{ $totalCBTotalFl }}</td>
                                                        <td>{{ $totalCLTotalFl }}</td>
                                                    </tr>
                                                    <tr style="background-color: #ffff99;">
                                                        <td class="text-left text-bold">Total</td>
                                                        <td>{{ $totalRegularTotal1 + $totalFlTotal1 }}</td>
                                                        <td>{{ $totalHTotalReg + $totalHTotalFl }}</td>
                                                        <td>{{ $totalTATotalReg + $totalTATotalFl }}</td>
                                                        <td>{{ $totalDTotalReg + $totalDTotalFl }}</td>
                                                        <td>{{ $totalLTotalReg + $totalLTotalFl }}</td>
                                                        <td>{{ $totalMTotalReg + $totalMTotalFl }}</td>
                                                        <td>{{ $totalMXTotalReg + $totalMXTotalFl }}</td>
                                                        <td>{{ $totalSTotalReg + $totalSTotalFl }}</td>
                                                        <td>{{ $totalSXTotalReg + $totalSXTotalFl }}</td>
                                                        <td>{{ $totalITotalReg + $totalITotalFl }}</td>
                                                        <td>{{ $totalIPTotalReg + $totalIPTotalFl }}</td>
                                                        <td>{{ $totalIXTotalReg + $totalIXTotalFl }}</td>
                                                        <td>{{ $totalCTTotalReg + $totalCTTotalFl }}</td>
                                                        <td>{{ $totalCHTotalReg + $totalCHTotalFl }}</td>
                                                        <td>{{ $totalCBTotalReg + $totalCBTotalFl }}</td>
                                                        <td>{{ $totalCLTotalReg + $totalCLTotalFl }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>

                        {{-- I/C --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: I/C</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalC }}</td>
                                                        @if($staffAttC->isEmpty())
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
                                                        @foreach ($staffAttC as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalC }}</td>
                                                        @if($monAttC->isEmpty())
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
                                                        @foreach ($monAttC as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalC }}</td>
                                                        @if($regAttC->isEmpty())
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
                                                        @foreach ($regAttC as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalC }}</td>
                                                        @if($bskpAttC->isEmpty())
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
                                                        @foreach ($bskpAttC as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalC }}</td>
                                                        @if($flAttC->isEmpty())
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
                                                        @foreach ($flAttC as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalC + $monthlyTotalC + $regularTotalC + $bskpTotalC + $flTotalC }}</td>
                                                        <td>{{ $totalHFinalC }}</td>
                                                        <td>{{ $totalTAFinalC }}</td>
                                                        <td>{{ $totalDFinalC }}</td>
                                                        <td>{{ $totalLFinalC }}</td>
                                                        <td>{{ $totalMFinalC }}</td>
                                                        <td>{{ $totalMXFinalC }}</td>
                                                        <td>{{ $totalSFinalC }}</td>
                                                        <td>{{ $totalSXFinalC }}</td>
                                                        <td>{{ $totalIFinalC }}</td>
                                                        <td>{{ $totalIPFinalC }}</td>
                                                        <td>{{ $totalIXFinalC }}</td>
                                                        <td>{{ $totalCTFinalC }}</td>
                                                        <td>{{ $totalCHFinalC }}</td>
                                                        <td>{{ $totalCBFinalC }}</td>
                                                        <td>{{ $totalCLFinalC }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttC as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->h }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hC }}</td>
                                                        <td>{{ $total_taC }}</td>
                                                        <td>{{ $total_dC }}</td>
                                                        <td>{{ $total_lC }}</td>
                                                        <td>{{ $total_mC }}</td>
                                                        <td>{{ $total_mxC }}</td>
                                                        <td>{{ $total_sC }}</td>
                                                        <td>{{ $total_sxC }}</td>
                                                        <td>{{ $total_iC }}</td>
                                                        <td>{{ $total_ipC }}</td>
                                                        <td>{{ $total_ixC }}</td>
                                                        <td>{{ $total_ctC }}</td>
                                                        <td>{{ $total_chC }}</td>
                                                        <td>{{ $total_cbC }}</td>
                                                        <td>{{ $total_clC }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>3. Data Kehadiran Perkemandoran</h4>
                                            <table class="table" id="table-data">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Mandor</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Status</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Total<br>TK</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="padding-left:8px;padding-right:8px;width: 80px;">TA</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">M</th>
                                                        <th style="width: 80px;">MX</th>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">S</th>
                                                        <th style="width: 80px;">SX</th>
                                                        <th style="padding-left:16px;padding-right:16px;width: 80px;">I</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IP</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IX</th>
                                                        <th style="width: 80px;">CT</th>
                                                        <th style="width: 80px;">CH</th>
                                                        <th style="width: 80px;">CB</th>
                                                        <th style="width: 80px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($dataC as $item)
                                                        <tr class="text-left">
                                                            <td rowspan="4" style="text-align: center; vertical-align: middle;">{{ $counter++ }}</td>
                                                            <form action="{{ route('summary-per-dept-mandor-per-emp-for-dash') }}" method="POST">
                                                                @csrf
                                                                <td rowspan="4" class="text-left">
                                                                    <br>
                                                                    <input type="hidden" name="mandor_nik" value="{{ $item['mandor'] }}">
                                                                    <input type="hidden" name="date" value="{{ $item['date'] }}">
                                                                    <input type="hidden" name="dept" value="{{ $item['dept'] }}">
                                                                    {{ $item['mandorName'] }}
                                                                    <br><button class="btn btn-primary btn-sm" type="submit">Detail</button>
                                                                </td>
                                                            </form>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">Reg</td>
                                                            <td>{{ $item['regularTotal1C'] }}</td>
                                                            <td>{{ $item['totalHFinalRegC'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegC'] }}</td>
                                                            <td>{{ $item['totalDFinalRegC'] }}</td>
                                                            <td>{{ $item['totalLFinalRegC'] }}</td>
                                                            <td>{{ $item['totalMFinalRegC'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegC'] }}</td>
                                                            <td>{{ $item['totalSFinalRegC'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegC'] }}</td>
                                                            <td>{{ $item['totalIFinalRegC'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegC'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegC'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegC'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegC'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegC'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegC'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">FL</td>
                                                            <td>{{ $item['flTotal1C'] }}</td>
                                                            <td>{{ $item['totalHFinalFlC'] }}</td>
                                                            <td>{{ $item['totalTAFinalFlC'] }}</td>
                                                            <td>{{ $item['totalDFinalFlC'] }}</td>
                                                            <td>{{ $item['totalLFinalFlC'] }}</td>
                                                            <td>{{ $item['totalMFinalFlC'] }}</td>
                                                            <td>{{ $item['totalMXFinalFlC'] }}</td>
                                                            <td>{{ $item['totalSFinalFlC'] }}</td>
                                                            <td>{{ $item['totalSXFinalFlC'] }}</td>
                                                            <td>{{ $item['totalIFinalFlC'] }}</td>
                                                            <td>{{ $item['totalIPFinalFlC'] }}</td>
                                                            <td>{{ $item['totalIXFinalFlC'] }}</td>
                                                            <td>{{ $item['totalCTFinalFlC'] }}</td>
                                                            <td>{{ $item['totalCHFinalFlC'] }}</td>
                                                            <td>{{ $item['totalCBFinalFlC'] }}</td>
                                                            <td>{{ $item['totalCLFinalFlC'] }}</td>
                                                        </tr>
                                                        <tr style="background-color: #ffff99;">
                                                            <td class="text-left text-bold">Total</td>
                                                            <td>{{ $item['regularTotal1C'] + $item['flTotal1C'] }}</td>
                                                            <td>{{ $item['totalHFinalRegC'] + $item['totalHFinalFlC'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegC'] + $item['totalTAFinalFlC'] }}</td>
                                                            <td>{{ $item['totalDFinalRegC'] + $item['totalDFinalFlC'] }}</td>
                                                            <td>{{ $item['totalLFinalRegC'] + $item['totalLFinalFlC'] }}</td>
                                                            <td>{{ $item['totalMFinalRegC'] + $item['totalMFinalFlC'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegC'] + $item['totalMXFinalFlC'] }}</td>
                                                            <td>{{ $item['totalSFinalRegC'] + $item['totalSFinalFlC'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegC'] + $item['totalSXFinalFlC'] }}</td>
                                                            <td>{{ $item['totalIFinalRegC'] + $item['totalIFinalFlC'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegC'] + $item['totalIPFinalFlC'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegC'] + $item['totalIXFinalFlC'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegC'] + $item['totalCTFinalFlC'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegC'] + $item['totalCHFinalFlC'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegC'] + $item['totalCBFinalFlC'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegC'] + $item['totalCLFinalFlC'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td rowspan="4"></td>
                                                        <td rowspan="4" style="text-align: center; vertical-align: middle;">Total</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">Reg</td>
                                                        <td>{{ $totalRegularTotal1C }}</td>
                                                        <td>{{ $totalHTotalRegC }}</td>
                                                        <td>{{ $totalTATotalRegC }}</td>
                                                        <td>{{ $totalDTotalRegC }}</td>
                                                        <td>{{ $totalLTotalRegC }}</td>
                                                        <td>{{ $totalMTotalRegC }}</td>
                                                        <td>{{ $totalMXTotalRegC }}</td>
                                                        <td>{{ $totalSTotalRegC }}</td>
                                                        <td>{{ $totalSXTotalRegC }}</td>
                                                        <td>{{ $totalITotalRegC }}</td>
                                                        <td>{{ $totalIPTotalRegC }}</td>
                                                        <td>{{ $totalIXTotalRegC }}</td>
                                                        <td>{{ $totalCTTotalRegC }}</td>
                                                        <td>{{ $totalCHTotalRegC }}</td>
                                                        <td>{{ $totalCBTotalRegC }}</td>
                                                        <td>{{ $totalCLTotalRegC }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">FL</td>
                                                        <td>{{ $totalFlTotal1C }}</td>
                                                        <td>{{ $totalHTotalFlC }}</td>
                                                        <td>{{ $totalTATotalFlC }}</td>
                                                        <td>{{ $totalDTotalFlC }}</td>
                                                        <td>{{ $totalLTotalFlC }}</td>
                                                        <td>{{ $totalMTotalFlC }}</td>
                                                        <td>{{ $totalMXTotalFlC }}</td>
                                                        <td>{{ $totalSTotalFlC }}</td>
                                                        <td>{{ $totalSXTotalFlC }}</td>
                                                        <td>{{ $totalITotalFlC }}</td>
                                                        <td>{{ $totalIPTotalFlC }}</td>
                                                        <td>{{ $totalIXTotalFlC }}</td>
                                                        <td>{{ $totalCTTotalFlC }}</td>
                                                        <td>{{ $totalCHTotalFlC }}</td>
                                                        <td>{{ $totalCBTotalFlC }}</td>
                                                        <td>{{ $totalCLTotalFlC }}</td>
                                                    </tr>
                                                    <tr style="background-color: #ffff99;">
                                                        <td class="text-left text-bold">Total</td>
                                                        <td>{{ $totalRegularTotal1C + $totalFlTotal1C }}</td>
                                                        <td>{{ $totalHTotalRegC + $totalHTotalFlC }}</td>
                                                        <td>{{ $totalTATotalRegC + $totalTATotalFlC }}</td>
                                                        <td>{{ $totalDTotalRegC + $totalDTotalFlC }}</td>
                                                        <td>{{ $totalLTotalRegC + $totalLTotalFlC }}</td>
                                                        <td>{{ $totalMTotalRegC + $totalMTotalFlC }}</td>
                                                        <td>{{ $totalMXTotalRegC + $totalMXTotalFlC }}</td>
                                                        <td>{{ $totalSTotalRegC + $totalSTotalFlC }}</td>
                                                        <td>{{ $totalSXTotalRegC + $totalSXTotalFlC }}</td>
                                                        <td>{{ $totalITotalRegC + $totalITotalFlC }}</td>
                                                        <td>{{ $totalIPTotalRegC + $totalIPTotalFlC }}</td>
                                                        <td>{{ $totalIXTotalRegC + $totalIXTotalFlC }}</td>
                                                        <td>{{ $totalCTTotalRegC + $totalCTTotalFlC }}</td>
                                                        <td>{{ $totalCHTotalRegC + $totalCHTotalFlC }}</td>
                                                        <td>{{ $totalCBTotalRegC + $totalCBTotalFlC }}</td>
                                                        <td>{{ $totalCLTotalRegC + $totalCLTotalFlC }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>

                        {{-- II/D --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: II/D</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalD }}</td>
                                                        @if($staffAttD->isEmpty())
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
                                                        @foreach ($staffAttD as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalD }}</td>
                                                        @if($monAttD->isEmpty())
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
                                                        @foreach ($monAttD as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalD }}</td>
                                                        @if($regAttD->isEmpty())
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
                                                        @foreach ($regAttD as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalD }}</td>
                                                        @if($bskpAttD->isEmpty())
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
                                                        @foreach ($bskpAttD as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalD }}</td>
                                                        @if($flAttD->isEmpty())
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
                                                        @foreach ($flAttD as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalD + $monthlyTotalD + $regularTotalD + $bskpTotalD + $flTotalD }}</td>
                                                        <td>{{ $totalHFinalD }}</td>
                                                        <td>{{ $totalTAFinalD }}</td>
                                                        <td>{{ $totalDFinalD }}</td>
                                                        <td>{{ $totalLFinalD }}</td>
                                                        <td>{{ $totalMFinalD }}</td>
                                                        <td>{{ $totalMXFinalD }}</td>
                                                        <td>{{ $totalSFinalD }}</td>
                                                        <td>{{ $totalSXFinalD }}</td>
                                                        <td>{{ $totalIFinalD }}</td>
                                                        <td>{{ $totalIPFinalD }}</td>
                                                        <td>{{ $totalIXFinalD }}</td>
                                                        <td>{{ $totalCTFinalD }}</td>
                                                        <td>{{ $totalCHFinalD }}</td>
                                                        <td>{{ $totalCBFinalD }}</td>
                                                        <td>{{ $totalCLFinalD }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttD as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hD }}</td>
                                                        <td>{{ $total_taD }}</td>
                                                        <td>{{ $total_dD }}</td>
                                                        <td>{{ $total_lD }}</td>
                                                        <td>{{ $total_mD }}</td>
                                                        <td>{{ $total_mxD }}</td>
                                                        <td>{{ $total_sD }}</td>
                                                        <td>{{ $total_sxD }}</td>
                                                        <td>{{ $total_iD }}</td>
                                                        <td>{{ $total_ipD }}</td>
                                                        <td>{{ $total_ixD }}</td>
                                                        <td>{{ $total_ctD }}</td>
                                                        <td>{{ $total_chD }}</td>
                                                        <td>{{ $total_cbD }}</td>
                                                        <td>{{ $total_clD }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>3. Data Kehadiran Perkemandoran</h4>
                                            <table class="table" id="table-data">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Mandor</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Status</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Total<br>TK</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="padding-left:8px;padding-right:8px;width: 80px;">TA</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">M</th>
                                                        <th style="width: 80px;">MX</th>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">S</th>
                                                        <th style="width: 80px;">SX</th>
                                                        <th style="padding-left:16px;padding-right:16px;width: 80px;">I</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IP</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IX</th>
                                                        <th style="width: 80px;">CT</th>
                                                        <th style="width: 80px;">CH</th>
                                                        <th style="width: 80px;">CB</th>
                                                        <th style="width: 80px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($dataD as $item)
                                                        <tr class="text-left">
                                                            <td rowspan="4" style="text-align: center; vertical-align: middle;">{{ $counter++ }}</td>
                                                            <form action="{{ route('summary-per-dept-mandor-per-emp-for-dash') }}" method="POST">
                                                                @csrf
                                                                <td rowspan="4" class="text-left">
                                                                    <br>
                                                                    <input type="hidden" name="mandor_nik" value="{{ $item['mandor'] }}">
                                                                    <input type="hidden" name="date" value="{{ $item['date'] }}">
                                                                    <input type="hidden" name="dept" value="{{ $item['dept'] }}">
                                                                    {{ $item['mandorName'] }}
                                                                    <br><button class="btn btn-primary btn-sm" type="submit">Detail</button>
                                                                </td>
                                                            </form>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">Reg</td>
                                                            <td>{{ $item['regularTotal1D'] }}</td>
                                                            <td>{{ $item['totalHFinalRegD'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegD'] }}</td>
                                                            <td>{{ $item['totalDFinalRegD'] }}</td>
                                                            <td>{{ $item['totalLFinalRegD'] }}</td>
                                                            <td>{{ $item['totalMFinalRegD'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegD'] }}</td>
                                                            <td>{{ $item['totalSFinalRegD'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegD'] }}</td>
                                                            <td>{{ $item['totalIFinalRegD'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegD'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegD'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegD'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegD'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegD'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegD'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">FL</td>
                                                            <td>{{ $item['flTotal1D'] }}</td>
                                                            <td>{{ $item['totalHFinalFlD'] }}</td>
                                                            <td>{{ $item['totalTAFinalFlD'] }}</td>
                                                            <td>{{ $item['totalDFinalFlD'] }}</td>
                                                            <td>{{ $item['totalLFinalFlD'] }}</td>
                                                            <td>{{ $item['totalMFinalFlD'] }}</td>
                                                            <td>{{ $item['totalMXFinalFlD'] }}</td>
                                                            <td>{{ $item['totalSFinalFlD'] }}</td>
                                                            <td>{{ $item['totalSXFinalFlD'] }}</td>
                                                            <td>{{ $item['totalIFinalFlD'] }}</td>
                                                            <td>{{ $item['totalIPFinalFlD'] }}</td>
                                                            <td>{{ $item['totalIXFinalFlD'] }}</td>
                                                            <td>{{ $item['totalCTFinalFlD'] }}</td>
                                                            <td>{{ $item['totalCHFinalFlD'] }}</td>
                                                            <td>{{ $item['totalCBFinalFlD'] }}</td>
                                                            <td>{{ $item['totalCLFinalFlD'] }}</td>
                                                        </tr>
                                                        <tr style="background-color: #ffff99;">
                                                            <td class="text-left text-bold">Total</td>
                                                            <td>{{ $item['regularTotal1D'] + $item['flTotal1D'] }}</td>
                                                            <td>{{ $item['totalHFinalRegD'] + $item['totalHFinalFlD'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegD'] + $item['totalTAFinalFlD'] }}</td>
                                                            <td>{{ $item['totalDFinalRegD'] + $item['totalDFinalFlD'] }}</td>
                                                            <td>{{ $item['totalLFinalRegD'] + $item['totalLFinalFlD'] }}</td>
                                                            <td>{{ $item['totalMFinalRegD'] + $item['totalMFinalFlD'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegD'] + $item['totalMXFinalFlD'] }}</td>
                                                            <td>{{ $item['totalSFinalRegD'] + $item['totalSFinalFlD'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegD'] + $item['totalSXFinalFlD'] }}</td>
                                                            <td>{{ $item['totalIFinalRegD'] + $item['totalIFinalFlD'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegD'] + $item['totalIPFinalFlD'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegD'] + $item['totalIXFinalFlD'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegD'] + $item['totalCTFinalFlD'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegD'] + $item['totalCHFinalFlD'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegD'] + $item['totalCBFinalFlD'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegD'] + $item['totalCLFinalFlD'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td rowspan="4"></td>
                                                        <td rowspan="4" style="text-align: center; vertical-align: middle;">Total</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">Reg</td>
                                                        <td>{{ $totalRegularTotal1D }}</td>
                                                        <td>{{ $totalHTotalRegD }}</td>
                                                        <td>{{ $totalTATotalRegD }}</td>
                                                        <td>{{ $totalDTotalRegD }}</td>
                                                        <td>{{ $totalLTotalRegD }}</td>
                                                        <td>{{ $totalMTotalRegD }}</td>
                                                        <td>{{ $totalMXTotalRegD }}</td>
                                                        <td>{{ $totalSTotalRegD }}</td>
                                                        <td>{{ $totalSXTotalRegD }}</td>
                                                        <td>{{ $totalITotalRegD }}</td>
                                                        <td>{{ $totalIPTotalRegD }}</td>
                                                        <td>{{ $totalIXTotalRegD }}</td>
                                                        <td>{{ $totalCTTotalRegD }}</td>
                                                        <td>{{ $totalCHTotalRegD }}</td>
                                                        <td>{{ $totalCBTotalRegD }}</td>
                                                        <td>{{ $totalCLTotalRegD }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">FL</td>
                                                        <td>{{ $totalFlTotal1D }}</td>
                                                        <td>{{ $totalHTotalFlD }}</td>
                                                        <td>{{ $totalTATotalFlD }}</td>
                                                        <td>{{ $totalDTotalFlD }}</td>
                                                        <td>{{ $totalLTotalFlD }}</td>
                                                        <td>{{ $totalMTotalFlD }}</td>
                                                        <td>{{ $totalMXTotalFlD }}</td>
                                                        <td>{{ $totalSTotalFlD }}</td>
                                                        <td>{{ $totalSXTotalFlD }}</td>
                                                        <td>{{ $totalITotalFlD }}</td>
                                                        <td>{{ $totalIPTotalFlD }}</td>
                                                        <td>{{ $totalIXTotalFlD }}</td>
                                                        <td>{{ $totalCTTotalFlD }}</td>
                                                        <td>{{ $totalCHTotalFlD }}</td>
                                                        <td>{{ $totalCBTotalFlD }}</td>
                                                        <td>{{ $totalCLTotalFlD }}</td>
                                                    </tr>
                                                    <tr style="background-color: #ffff99;">
                                                        <td class="text-left text-bold">Total</td>
                                                        <td>{{ $totalRegularTotal1D + $totalFlTotal1D }}</td>
                                                        <td>{{ $totalHTotalRegD + $totalHTotalFlD }}</td>
                                                        <td>{{ $totalTATotalRegD + $totalTATotalFlD }}</td>
                                                        <td>{{ $totalDTotalRegD + $totalDTotalFlD }}</td>
                                                        <td>{{ $totalLTotalRegD + $totalLTotalFlD }}</td>
                                                        <td>{{ $totalMTotalRegD + $totalMTotalFlD }}</td>
                                                        <td>{{ $totalMXTotalRegD + $totalMXTotalFlD }}</td>
                                                        <td>{{ $totalSTotalRegD + $totalSTotalFlD }}</td>
                                                        <td>{{ $totalSXTotalRegD + $totalSXTotalFlD }}</td>
                                                        <td>{{ $totalITotalRegD + $totalITotalFlD }}</td>
                                                        <td>{{ $totalIPTotalRegD + $totalIPTotalFlD }}</td>
                                                        <td>{{ $totalIXTotalRegD + $totalIXTotalFlD }}</td>
                                                        <td>{{ $totalCTTotalRegD + $totalCTTotalFlD }}</td>
                                                        <td>{{ $totalCHTotalRegD + $totalCHTotalFlD }}</td>
                                                        <td>{{ $totalCBTotalRegD + $totalCBTotalFlD }}</td>
                                                        <td>{{ $totalCLTotalRegD + $totalCLTotalFlD }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>

                        {{-- II/E --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: II/E</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalE }}</td>
                                                        @if($staffAttE->isEmpty())
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
                                                        @foreach ($staffAttE as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalE }}</td>
                                                        @if($monAttE->isEmpty())
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
                                                        @foreach ($monAttE as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalE }}</td>
                                                        @if($regAttE->isEmpty())
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
                                                        @foreach ($regAttE as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalE }}</td>
                                                        @if($bskpAttE->isEmpty())
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
                                                        @foreach ($bskpAttE as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalE }}</td>
                                                        @if($flAttE->isEmpty())
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
                                                        @foreach ($flAttE as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalE + $monthlyTotalE + $regularTotalE + $bskpTotalE + $flTotalE }}</td>
                                                        <td>{{ $totalHFinalE }}</td>
                                                        <td>{{ $totalTAFinalE }}</td>
                                                        <td>{{ $totalDFinalE }}</td>
                                                        <td>{{ $totalLFinalE }}</td>
                                                        <td>{{ $totalMFinalE }}</td>
                                                        <td>{{ $totalMXFinalE }}</td>
                                                        <td>{{ $totalSFinalE }}</td>
                                                        <td>{{ $totalSXFinalE }}</td>
                                                        <td>{{ $totalIFinalE }}</td>
                                                        <td>{{ $totalIPFinalE }}</td>
                                                        <td>{{ $totalIXFinalE }}</td>
                                                        <td>{{ $totalCTFinalE }}</td>
                                                        <td>{{ $totalCHFinalE }}</td>
                                                        <td>{{ $totalCBFinalE }}</td>
                                                        <td>{{ $totalCLFinalE }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttE as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->h }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hE }}</td>
                                                        <td>{{ $total_taE }}</td>
                                                        <td>{{ $total_dE }}</td>
                                                        <td>{{ $total_lE }}</td>
                                                        <td>{{ $total_mE }}</td>
                                                        <td>{{ $total_mxE }}</td>
                                                        <td>{{ $total_sE }}</td>
                                                        <td>{{ $total_sxE }}</td>
                                                        <td>{{ $total_iE }}</td>
                                                        <td>{{ $total_ipE }}</td>
                                                        <td>{{ $total_ixE }}</td>
                                                        <td>{{ $total_ctE }}</td>
                                                        <td>{{ $total_chE }}</td>
                                                        <td>{{ $total_cbE }}</td>
                                                        <td>{{ $total_clE }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>3. Data Kehadiran Perkemandoran</h4>
                                            <table class="table" id="table-data">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Mandor</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Status</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Total<br>TK</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="padding-left:8px;padding-right:8px;width: 80px;">TA</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">M</th>
                                                        <th style="width: 80px;">MX</th>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">S</th>
                                                        <th style="width: 80px;">SX</th>
                                                        <th style="padding-left:16px;padding-right:16px;width: 80px;">I</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IP</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IX</th>
                                                        <th style="width: 80px;">CT</th>
                                                        <th style="width: 80px;">CH</th>
                                                        <th style="width: 80px;">CB</th>
                                                        <th style="width: 80px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($dataE as $item)
                                                        <tr class="text-left">
                                                            <td rowspan="4" style="text-align: center; vertical-align: middle;">{{ $counter++ }}</td>
                                                            <form action="{{ route('summary-per-dept-mandor-per-emp-for-dash') }}" method="POST">
                                                                @csrf
                                                                <td rowspan="4" class="text-left">
                                                                    <br>
                                                                    <input type="hidden" name="mandor_nik" value="{{ $item['mandor'] }}">
                                                                    <input type="hidden" name="date" value="{{ $item['date'] }}">
                                                                    <input type="hidden" name="dept" value="{{ $item['dept'] }}">
                                                                    {{ $item['mandorName'] }}
                                                                    <br><button class="btn btn-primary btn-sm" type="submit">Detail</button>
                                                                </td>
                                                            </form>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">Reg</td>
                                                            <td>{{ $item['regularTotal1E'] }}</td>
                                                            <td>{{ $item['totalHFinalRegE'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegE'] }}</td>
                                                            <td>{{ $item['totalDFinalRegE'] }}</td>
                                                            <td>{{ $item['totalLFinalRegE'] }}</td>
                                                            <td>{{ $item['totalMFinalRegE'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegE'] }}</td>
                                                            <td>{{ $item['totalSFinalRegE'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegE'] }}</td>
                                                            <td>{{ $item['totalIFinalRegE'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegE'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegE'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegE'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegE'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegE'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegE'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">FL</td>
                                                            <td>{{ $item['flTotal1E'] }}</td>
                                                            <td>{{ $item['totalHFinalFlE'] }}</td>
                                                            <td>{{ $item['totalTAFinalFlE'] }}</td>
                                                            <td>{{ $item['totalDFinalFlE'] }}</td>
                                                            <td>{{ $item['totalLFinalFlE'] }}</td>
                                                            <td>{{ $item['totalMFinalFlE'] }}</td>
                                                            <td>{{ $item['totalMXFinalFlE'] }}</td>
                                                            <td>{{ $item['totalSFinalFlE'] }}</td>
                                                            <td>{{ $item['totalSXFinalFlE'] }}</td>
                                                            <td>{{ $item['totalIFinalFlE'] }}</td>
                                                            <td>{{ $item['totalIPFinalFlE'] }}</td>
                                                            <td>{{ $item['totalIXFinalFlE'] }}</td>
                                                            <td>{{ $item['totalCTFinalFlE'] }}</td>
                                                            <td>{{ $item['totalCHFinalFlE'] }}</td>
                                                            <td>{{ $item['totalCBFinalFlE'] }}</td>
                                                            <td>{{ $item['totalCLFinalFlE'] }}</td>
                                                        </tr>
                                                        <tr style="background-color: #ffff99;">
                                                            <td class="text-left text-bold">Total</td>
                                                            <td>{{ $item['regularTotal1E'] + $item['flTotal1E'] }}</td>
                                                            <td>{{ $item['totalHFinalRegE'] + $item['totalHFinalFlE'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegE'] + $item['totalTAFinalFlE'] }}</td>
                                                            <td>{{ $item['totalDFinalRegE'] + $item['totalDFinalFlE'] }}</td>
                                                            <td>{{ $item['totalLFinalRegE'] + $item['totalLFinalFlE'] }}</td>
                                                            <td>{{ $item['totalMFinalRegE'] + $item['totalMFinalFlE'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegE'] + $item['totalMXFinalFlE'] }}</td>
                                                            <td>{{ $item['totalSFinalRegE'] + $item['totalSFinalFlE'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegE'] + $item['totalSXFinalFlE'] }}</td>
                                                            <td>{{ $item['totalIFinalRegE'] + $item['totalIFinalFlE'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegE'] + $item['totalIPFinalFlE'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegE'] + $item['totalIXFinalFlE'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegE'] + $item['totalCTFinalFlE'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegE'] + $item['totalCHFinalFlE'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegE'] + $item['totalCBFinalFlE'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegE'] + $item['totalCLFinalFlE'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td rowspan="4"></td>
                                                        <td rowspan="4" style="text-align: center; vertical-align: middle;">Total</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">Reg</td>
                                                        <td>{{ $totalRegularTotal1E }}</td>
                                                        <td>{{ $totalHTotalRegE }}</td>
                                                        <td>{{ $totalTATotalRegE }}</td>
                                                        <td>{{ $totalDTotalRegE }}</td>
                                                        <td>{{ $totalLTotalRegE }}</td>
                                                        <td>{{ $totalMTotalRegE }}</td>
                                                        <td>{{ $totalMXTotalRegE }}</td>
                                                        <td>{{ $totalSTotalRegE }}</td>
                                                        <td>{{ $totalSXTotalRegE }}</td>
                                                        <td>{{ $totalITotalRegE }}</td>
                                                        <td>{{ $totalIPTotalRegE }}</td>
                                                        <td>{{ $totalIXTotalRegE }}</td>
                                                        <td>{{ $totalCTTotalRegE }}</td>
                                                        <td>{{ $totalCHTotalRegE }}</td>
                                                        <td>{{ $totalCBTotalRegE }}</td>
                                                        <td>{{ $totalCLTotalRegE }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">FL</td>
                                                        <td>{{ $totalFlTotal1E }}</td>
                                                        <td>{{ $totalHTotalFlE }}</td>
                                                        <td>{{ $totalTATotalFlE }}</td>
                                                        <td>{{ $totalDTotalFlE }}</td>
                                                        <td>{{ $totalLTotalFlE }}</td>
                                                        <td>{{ $totalMTotalFlE }}</td>
                                                        <td>{{ $totalMXTotalFlE }}</td>
                                                        <td>{{ $totalSTotalFlE }}</td>
                                                        <td>{{ $totalSXTotalFlE }}</td>
                                                        <td>{{ $totalITotalFlE }}</td>
                                                        <td>{{ $totalIPTotalFlE }}</td>
                                                        <td>{{ $totalIXTotalFlE }}</td>
                                                        <td>{{ $totalCTTotalFlE }}</td>
                                                        <td>{{ $totalCHTotalFlE }}</td>
                                                        <td>{{ $totalCBTotalFlE }}</td>
                                                        <td>{{ $totalCLTotalFlE }}</td>
                                                    </tr>
                                                    <tr style="background-color: #ffff99;">
                                                        <td class="text-left text-bold">Total</td>
                                                        <td>{{ $totalRegularTotal1E + $totalFlTotal1E }}</td>
                                                        <td>{{ $totalHTotalRegE + $totalHTotalFlE }}</td>
                                                        <td>{{ $totalTATotalRegE + $totalTATotalFlE }}</td>
                                                        <td>{{ $totalDTotalRegE + $totalDTotalFlE }}</td>
                                                        <td>{{ $totalLTotalRegE + $totalLTotalFlE }}</td>
                                                        <td>{{ $totalMTotalRegE + $totalMTotalFlE }}</td>
                                                        <td>{{ $totalMXTotalRegE + $totalMXTotalFlE }}</td>
                                                        <td>{{ $totalSTotalRegE + $totalSTotalFlE }}</td>
                                                        <td>{{ $totalSXTotalRegE + $totalSXTotalFlE }}</td>
                                                        <td>{{ $totalITotalRegE + $totalITotalFlE }}</td>
                                                        <td>{{ $totalIPTotalRegE + $totalIPTotalFlE }}</td>
                                                        <td>{{ $totalIXTotalRegE + $totalIXTotalFlE }}</td>
                                                        <td>{{ $totalCTTotalRegE + $totalCTTotalFlE }}</td>
                                                        <td>{{ $totalCHTotalRegE + $totalCHTotalFlE }}</td>
                                                        <td>{{ $totalCBTotalRegE + $totalCBTotalFlE }}</td>
                                                        <td>{{ $totalCLTotalRegE + $totalCLTotalFlE }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>

                        {{-- II/F --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: II/F</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalF }}</td>
                                                        @if($staffAttF->isEmpty())
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
                                                        @foreach ($staffAttF as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalF }}</td>
                                                        @if($monAttF->isEmpty())
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
                                                        @foreach ($monAttF as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalF }}</td>
                                                        @if($regAttF->isEmpty())
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
                                                        @foreach ($regAttF as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalF }}</td>
                                                        @if($bskpAttF->isEmpty())
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
                                                        @foreach ($bskpAttF as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalF }}</td>
                                                        @if($flAttF->isEmpty())
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
                                                        @foreach ($flAttF as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalF + $monthlyTotalF + $regularTotalF + $bskpTotalF + $flTotalF }}</td>
                                                        <td>{{ $totalHFinalF }}</td>
                                                        <td>{{ $totalTAFinalF }}</td>
                                                        <td>{{ $totalDFinalF }}</td>
                                                        <td>{{ $totalLFinalF }}</td>
                                                        <td>{{ $totalMFinalF }}</td>
                                                        <td>{{ $totalMXFinalF }}</td>
                                                        <td>{{ $totalSFinalF }}</td>
                                                        <td>{{ $totalSXFinalF }}</td>
                                                        <td>{{ $totalIFinalF }}</td>
                                                        <td>{{ $totalIPFinalF }}</td>
                                                        <td>{{ $totalIXFinalF }}</td>
                                                        <td>{{ $totalCTFinalF }}</td>
                                                        <td>{{ $totalCHFinalF }}</td>
                                                        <td>{{ $totalCBFinalF }}</td>
                                                        <td>{{ $totalCLFinalF }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttF as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->h }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hF }}</td>
                                                        <td>{{ $total_taF }}</td>
                                                        <td>{{ $total_dF }}</td>
                                                        <td>{{ $total_lF }}</td>
                                                        <td>{{ $total_mF }}</td>
                                                        <td>{{ $total_mxF }}</td>
                                                        <td>{{ $total_sF }}</td>
                                                        <td>{{ $total_sxF }}</td>
                                                        <td>{{ $total_iF }}</td>
                                                        <td>{{ $total_ipF }}</td>
                                                        <td>{{ $total_ixF }}</td>
                                                        <td>{{ $total_ctF }}</td>
                                                        <td>{{ $total_chF }}</td>
                                                        <td>{{ $total_cbF }}</td>
                                                        <td>{{ $total_clF }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>3. Data Kehadiran Perkemandoran</h4>
                                            <table class="table" id="table-data">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Mandor</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Status</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Total<br>TK</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="padding-left:8px;padding-right:8px;width: 80px;">TA</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">M</th>
                                                        <th style="width: 80px;">MX</th>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">S</th>
                                                        <th style="width: 80px;">SX</th>
                                                        <th style="padding-left:16px;padding-right:16px;width: 80px;">I</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IP</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IX</th>
                                                        <th style="width: 80px;">CT</th>
                                                        <th style="width: 80px;">CH</th>
                                                        <th style="width: 80px;">CB</th>
                                                        <th style="width: 80px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($dataF as $item)
                                                        <tr class="text-left">
                                                            <td rowspan="4" style="text-align: center; vertical-align: middle;">{{ $counter++ }}</td>
                                                            <form action="{{ route('summary-per-dept-mandor-per-emp-for-dash') }}" method="POST">
                                                                @csrf
                                                                <td rowspan="4" class="text-left">
                                                                    <br>
                                                                    <input type="hidden" name="mandor_nik" value="{{ $item['mandor'] }}">
                                                                    <input type="hidden" name="date" value="{{ $item['date'] }}">
                                                                    <input type="hidden" name="dept" value="{{ $item['dept'] }}">
                                                                    {{ $item['mandorName'] }}
                                                                    <br><button class="btn btn-primary btn-sm" type="submit">Detail</button>
                                                                </td>
                                                            </form>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">Reg</td>
                                                            <td>{{ $item['regularTotal1F'] }}</td>
                                                            <td>{{ $item['totalHFinalRegF'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegF'] }}</td>
                                                            <td>{{ $item['totalDFinalRegF'] }}</td>
                                                            <td>{{ $item['totalLFinalRegF'] }}</td>
                                                            <td>{{ $item['totalMFinalRegF'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegF'] }}</td>
                                                            <td>{{ $item['totalSFinalRegF'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegF'] }}</td>
                                                            <td>{{ $item['totalIFinalRegF'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegF'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegF'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegF'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegF'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegF'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegF'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">FL</td>
                                                            <td>{{ $item['flTotal1F'] }}</td>
                                                            <td>{{ $item['totalHFinalFlF'] }}</td>
                                                            <td>{{ $item['totalTAFinalFlF'] }}</td>
                                                            <td>{{ $item['totalDFinalFlF'] }}</td>
                                                            <td>{{ $item['totalLFinalFlF'] }}</td>
                                                            <td>{{ $item['totalMFinalFlF'] }}</td>
                                                            <td>{{ $item['totalMXFinalFlF'] }}</td>
                                                            <td>{{ $item['totalSFinalFlF'] }}</td>
                                                            <td>{{ $item['totalSXFinalFlF'] }}</td>
                                                            <td>{{ $item['totalIFinalFlF'] }}</td>
                                                            <td>{{ $item['totalIPFinalFlF'] }}</td>
                                                            <td>{{ $item['totalIXFinalFlF'] }}</td>
                                                            <td>{{ $item['totalCTFinalFlF'] }}</td>
                                                            <td>{{ $item['totalCHFinalFlF'] }}</td>
                                                            <td>{{ $item['totalCBFinalFlF'] }}</td>
                                                            <td>{{ $item['totalCLFinalFlF'] }}</td>
                                                        </tr>
                                                        <tr style="background-color: #ffff99;">
                                                            <td class="text-left text-bold">Total</td>
                                                            <td>{{ $item['regularTotal1F'] + $item['flTotal1F'] }}</td>
                                                            <td>{{ $item['totalHFinalRegF'] + $item['totalHFinalFlF'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegF'] + $item['totalTAFinalFlF'] }}</td>
                                                            <td>{{ $item['totalDFinalRegF'] + $item['totalDFinalFlF'] }}</td>
                                                            <td>{{ $item['totalLFinalRegF'] + $item['totalLFinalFlF'] }}</td>
                                                            <td>{{ $item['totalMFinalRegF'] + $item['totalMFinalFlF'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegF'] + $item['totalMXFinalFlF'] }}</td>
                                                            <td>{{ $item['totalSFinalRegF'] + $item['totalSFinalFlF'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegF'] + $item['totalSXFinalFlF'] }}</td>
                                                            <td>{{ $item['totalIFinalRegF'] + $item['totalIFinalFlF'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegF'] + $item['totalIPFinalFlF'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegF'] + $item['totalIXFinalFlF'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegF'] + $item['totalCTFinalFlF'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegF'] + $item['totalCHFinalFlF'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegF'] + $item['totalCBFinalFlF'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegF'] + $item['totalCLFinalFlF'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td rowspan="4"></td>
                                                        <td rowspan="4" style="text-align: center; vertical-align: middle;">Total</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">Reg</td>
                                                        <td>{{ $totalRegularTotal1F }}</td>
                                                        <td>{{ $totalHTotalRegF }}</td>
                                                        <td>{{ $totalTATotalRegF }}</td>
                                                        <td>{{ $totalDTotalRegF }}</td>
                                                        <td>{{ $totalLTotalRegF }}</td>
                                                        <td>{{ $totalMTotalRegF }}</td>
                                                        <td>{{ $totalMXTotalRegF }}</td>
                                                        <td>{{ $totalSTotalRegF }}</td>
                                                        <td>{{ $totalSXTotalRegF }}</td>
                                                        <td>{{ $totalITotalRegF }}</td>
                                                        <td>{{ $totalIPTotalRegF }}</td>
                                                        <td>{{ $totalIXTotalRegF }}</td>
                                                        <td>{{ $totalCTTotalRegF }}</td>
                                                        <td>{{ $totalCHTotalRegF }}</td>
                                                        <td>{{ $totalCBTotalRegF }}</td>
                                                        <td>{{ $totalCLTotalRegF }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">FL</td>
                                                        <td>{{ $totalFlTotal1F }}</td>
                                                        <td>{{ $totalHTotalFlF }}</td>
                                                        <td>{{ $totalTATotalFlF }}</td>
                                                        <td>{{ $totalDTotalFlF }}</td>
                                                        <td>{{ $totalLTotalFlF }}</td>
                                                        <td>{{ $totalMTotalFlF }}</td>
                                                        <td>{{ $totalMXTotalFlF }}</td>
                                                        <td>{{ $totalSTotalFlF }}</td>
                                                        <td>{{ $totalSXTotalFlF }}</td>
                                                        <td>{{ $totalITotalFlF }}</td>
                                                        <td>{{ $totalIPTotalFlF }}</td>
                                                        <td>{{ $totalIXTotalFlF }}</td>
                                                        <td>{{ $totalCTTotalFlF }}</td>
                                                        <td>{{ $totalCHTotalFlF }}</td>
                                                        <td>{{ $totalCBTotalFlF }}</td>
                                                        <td>{{ $totalCLTotalFlF }}</td>
                                                    </tr>
                                                    <tr style="background-color: #ffff99;">
                                                        <td class="text-left text-bold">Total</td>
                                                        <td>{{ $totalRegularTotal1F + $totalFlTotal1F }}</td>
                                                        <td>{{ $totalHTotalRegF + $totalHTotalFlF }}</td>
                                                        <td>{{ $totalTATotalRegF + $totalTATotalFlF }}</td>
                                                        <td>{{ $totalDTotalRegF + $totalDTotalFlF }}</td>
                                                        <td>{{ $totalLTotalRegF + $totalLTotalFlF }}</td>
                                                        <td>{{ $totalMTotalRegF + $totalMTotalFlF }}</td>
                                                        <td>{{ $totalMXTotalRegF + $totalMXTotalFlF }}</td>
                                                        <td>{{ $totalSTotalRegF + $totalSTotalFlF }}</td>
                                                        <td>{{ $totalSXTotalRegF + $totalSXTotalFlF }}</td>
                                                        <td>{{ $totalITotalRegF + $totalITotalFlF }}</td>
                                                        <td>{{ $totalIPTotalRegF + $totalIPTotalFlF }}</td>
                                                        <td>{{ $totalIXTotalRegF + $totalIXTotalFlF }}</td>
                                                        <td>{{ $totalCTTotalRegF + $totalCTTotalFlF }}</td>
                                                        <td>{{ $totalCHTotalRegF + $totalCHTotalFlF }}</td>
                                                        <td>{{ $totalCBTotalRegF + $totalCBTotalFlF }}</td>
                                                        <td>{{ $totalCLTotalRegF + $totalCLTotalFlF }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>

                        {{-- Acc & Fin --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: Acc & Fin</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalAF }}</td>
                                                        @if($staffAttAF->isEmpty())
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
                                                        @foreach ($staffAttAF as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalAF }}</td>
                                                        @if($monAttAF->isEmpty())
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
                                                        @foreach ($monAttAF as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalAF }}</td>
                                                        @if($regAttAF->isEmpty())
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
                                                        @foreach ($regAttAF as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalAF }}</td>
                                                        @if($bskpAttAF->isEmpty())
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
                                                        @foreach ($bskpAttAF as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalAF }}</td>
                                                        @if($flAttAF->isEmpty())
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
                                                        @foreach ($flAttAF as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalAF + $monthlyTotalAF + $regularTotalAF + $bskpTotalAF + $flTotalAF }}</td>
                                                        <td>{{ $totalHFinalAF }}</td>
                                                        <td>{{ $totalTAFinalAF }}</td>
                                                        <td>{{ $totalDFinalAF }}</td>
                                                        <td>{{ $totalLFinalAF }}</td>
                                                        <td>{{ $totalMFinalAF }}</td>
                                                        <td>{{ $totalMXFinalAF }}</td>
                                                        <td>{{ $totalSFinalAF }}</td>
                                                        <td>{{ $totalSXFinalAF }}</td>
                                                        <td>{{ $totalIFinalAF }}</td>
                                                        <td>{{ $totalIPFinalAF }}</td>
                                                        <td>{{ $totalIXFinalAF }}</td>
                                                        <td>{{ $totalCTFinalAF }}</td>
                                                        <td>{{ $totalCHFinalAF }}</td>
                                                        <td>{{ $totalCBFinalAF }}</td>
                                                        <td>{{ $totalCLFinalAF }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttAF as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hAF }}</td>
                                                        <td>{{ $total_taAF }}</td>
                                                        <td>{{ $total_dAF }}</td>
                                                        <td>{{ $total_lAF }}</td>
                                                        <td>{{ $total_mAF }}</td>
                                                        <td>{{ $total_mxAF }}</td>
                                                        <td>{{ $total_sAF }}</td>
                                                        <td>{{ $total_sxAF }}</td>
                                                        <td>{{ $total_iAF }}</td>
                                                        <td>{{ $total_ipAF }}</td>
                                                        <td>{{ $total_ixAF }}</td>
                                                        <td>{{ $total_ctAF }}</td>
                                                        <td>{{ $total_chAF }}</td>
                                                        <td>{{ $total_cbAF }}</td>
                                                        <td>{{ $total_clAF }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- BSKP --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: BSKP</h4>
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
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalBSKP }}</td>
                                                        @if($staffAttBSKP->isEmpty())
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
                                                        @foreach ($staffAttBSKP as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalBSKP }}</td>
                                                        @if($monAttBSKP->isEmpty())
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
                                                        @foreach ($monAttBSKP as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalBSKP }}</td>
                                                        @if($regAttBSKP->isEmpty())
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
                                                        @foreach ($regAttBSKP as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalBSKP }}</td>
                                                        @if($bskpAttBSKP->isEmpty())
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
                                                        @foreach ($bskpAttBSKP as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalBSKP }}</td>
                                                        @if($flAttBSKP->isEmpty())
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
                                                        @foreach ($flAttBSKP as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalBSKP + $monthlyTotalBSKP + $regularTotalBSKP + $bskpTotalBSKP + $flTotalBSKP }}</td>
                                                        <td>{{ $totalHFinalBSKP }}</td>
                                                        <td>{{ $totalTAFinalBSKP }}</td>
                                                        <td>{{ $totalDFinalBSKP }}</td>
                                                        <td>{{ $totalLFinalBSKP }}</td>
                                                        <td>{{ $totalMFinalBSKP }}</td>
                                                        <td>{{ $totalMXFinalBSKP }}</td>
                                                        <td>{{ $totalSFinalBSKP }}</td>
                                                        <td>{{ $totalSXFinalBSKP }}</td>
                                                        <td>{{ $totalIFinalBSKP }}</td>
                                                        <td>{{ $totalIPFinalBSKP }}</td>
                                                        <td>{{ $totalIXFinalBSKP }}</td>
                                                        <td>{{ $totalCTFinalBSKP }}</td>
                                                        <td>{{ $totalCHFinalBSKP }}</td>
                                                        <td>{{ $totalCBFinalBSKP }}</td>
                                                        <td>{{ $totalCLFinalBSKP }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttBSKP as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hBSKP }}</td>
                                                        <td>{{ $total_taBSKP }}</td>
                                                        <td>{{ $total_dBSKP }}</td>
                                                        <td>{{ $total_lBSKP }}</td>
                                                        <td>{{ $total_mBSKP }}</td>
                                                        <td>{{ $total_mxBSKP }}</td>
                                                        <td>{{ $total_sBSKP }}</td>
                                                        <td>{{ $total_sxBSKP }}</td>
                                                        <td>{{ $total_iBSKP }}</td>
                                                        <td>{{ $total_ipBSKP }}</td>
                                                        <td>{{ $total_ixBSKP }}</td>
                                                        <td>{{ $total_ctBSKP }}</td>
                                                        <td>{{ $total_chBSKP }}</td>
                                                        <td>{{ $total_cbBSKP }}</td>
                                                        <td>{{ $total_clBSKP }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- FSD --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: FSD</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalFSD }}</td>
                                                        @if($staffAttFSD->isEmpty())
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
                                                        @foreach ($staffAttFSD as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalFSD }}</td>
                                                        @if($monAttFSD->isEmpty())
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
                                                        @foreach ($monAttFSD as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalFSD }}</td>
                                                        @if($regAttFSD->isEmpty())
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
                                                        @foreach ($regAttFSD as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalFSD }}</td>
                                                        @if($bskpAttFSD->isEmpty())
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
                                                        @foreach ($bskpAttFSD as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalFSD }}</td>
                                                        @if($flAttFSD->isEmpty())
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
                                                        @foreach ($flAttFSD as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalFSD + $monthlyTotalFSD + $regularTotalFSD + $bskpTotalFSD + $flTotalFSD }}</td>
                                                        <td>{{ $totalHFinalFSD }}</td>
                                                        <td>{{ $totalTAFinalFSD }}</td>
                                                        <td>{{ $totalDFinalFSD }}</td>
                                                        <td>{{ $totalLFinalFSD }}</td>
                                                        <td>{{ $totalMFinalFSD }}</td>
                                                        <td>{{ $totalMXFinalFSD }}</td>
                                                        <td>{{ $totalSFinalFSD }}</td>
                                                        <td>{{ $totalSXFinalFSD }}</td>
                                                        <td>{{ $totalIFinalFSD }}</td>
                                                        <td>{{ $totalIPFinalFSD }}</td>
                                                        <td>{{ $totalIXFinalFSD }}</td>
                                                        <td>{{ $totalCTFinalFSD }}</td>
                                                        <td>{{ $totalCHFinalFSD }}</td>
                                                        <td>{{ $totalCBFinalFSD }}</td>
                                                        <td>{{ $totalCLFinalFSD }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttFSD as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hFSD }}</td>
                                                        <td>{{ $total_taFSD }}</td>
                                                        <td>{{ $total_dFSD }}</td>
                                                        <td>{{ $total_lFSD }}</td>
                                                        <td>{{ $total_mFSD }}</td>
                                                        <td>{{ $total_mxFSD }}</td>
                                                        <td>{{ $total_sFSD }}</td>
                                                        <td>{{ $total_sxFSD }}</td>
                                                        <td>{{ $total_iFSD }}</td>
                                                        <td>{{ $total_ipFSD }}</td>
                                                        <td>{{ $total_ixFSD }}</td>
                                                        <td>{{ $total_ctFSD }}</td>
                                                        <td>{{ $total_chFSD }}</td>
                                                        <td>{{ $total_cbFSD }}</td>
                                                        <td>{{ $total_clFSD }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Field --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: Field</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalField }}</td>
                                                        @if($staffAttField->isEmpty())
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
                                                        @foreach ($staffAttField as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalField }}</td>
                                                        @if($monAttField->isEmpty())
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
                                                        @foreach ($monAttField as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalField }}</td>
                                                        @if($regAttField->isEmpty())
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
                                                        @foreach ($regAttField as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalField }}</td>
                                                        @if($bskpAttField->isEmpty())
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
                                                        @foreach ($bskpAttField as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalField }}</td>
                                                        @if($flAttField->isEmpty())
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
                                                        @foreach ($flAttField as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalField + $monthlyTotalField + $regularTotalField + $bskpTotalField + $flTotalField }}</td>
                                                        <td>{{ $totalHFinalField }}</td>
                                                        <td>{{ $totalTAFinalField }}</td>
                                                        <td>{{ $totalDFinalField }}</td>
                                                        <td>{{ $totalLFinalField }}</td>
                                                        <td>{{ $totalMFinalField }}</td>
                                                        <td>{{ $totalMXFinalField }}</td>
                                                        <td>{{ $totalSFinalField }}</td>
                                                        <td>{{ $totalSXFinalField }}</td>
                                                        <td>{{ $totalIFinalField }}</td>
                                                        <td>{{ $totalIPFinalField }}</td>
                                                        <td>{{ $totalIXFinalField }}</td>
                                                        <td>{{ $totalCTFinalField }}</td>
                                                        <td>{{ $totalCHFinalField }}</td>
                                                        <td>{{ $totalCBFinalField }}</td>
                                                        <td>{{ $totalCLFinalField }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttField as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hField }}</td>
                                                        <td>{{ $total_taField }}</td>
                                                        <td>{{ $total_dField }}</td>
                                                        <td>{{ $total_lField }}</td>
                                                        <td>{{ $total_mField }}</td>
                                                        <td>{{ $total_mxField }}</td>
                                                        <td>{{ $total_sField }}</td>
                                                        <td>{{ $total_sxField }}</td>
                                                        <td>{{ $total_iField }}</td>
                                                        <td>{{ $total_ipField }}</td>
                                                        <td>{{ $total_ixField }}</td>
                                                        <td>{{ $total_ctField }}</td>
                                                        <td>{{ $total_chField }}</td>
                                                        <td>{{ $total_cbField }}</td>
                                                        <td>{{ $total_clField }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Factory --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: Factory</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalFac }}</td>
                                                        @if($staffAttFac->isEmpty())
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
                                                        @foreach ($staffAttFac as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalFac }}</td>
                                                        @if($monAttFac->isEmpty())
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
                                                        @foreach ($monAttFac as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalFac }}</td>
                                                        @if($regAttFac->isEmpty())
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
                                                        @foreach ($regAttFac as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalFac }}</td>
                                                        @if($bskpAttFac->isEmpty())
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
                                                        @foreach ($bskpAttFac as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalFac }}</td>
                                                        @if($flAttFac->isEmpty())
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
                                                        @foreach ($flAttFac as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalFac + $monthlyTotalFac + $regularTotalFac + $bskpTotalFac + $flTotalFac }}</td>
                                                        <td>{{ $totalHFinalFac }}</td>
                                                        <td>{{ $totalTAFinalFac }}</td>
                                                        <td>{{ $totalDFinalFac }}</td>
                                                        <td>{{ $totalLFinalFac }}</td>
                                                        <td>{{ $totalMFinalFac }}</td>
                                                        <td>{{ $totalMXFinalFac }}</td>
                                                        <td>{{ $totalSFinalFac }}</td>
                                                        <td>{{ $totalSXFinalFac }}</td>
                                                        <td>{{ $totalIFinalFac }}</td>
                                                        <td>{{ $totalIPFinalFac }}</td>
                                                        <td>{{ $totalIXFinalFac }}</td>
                                                        <td>{{ $totalCTFinalFac }}</td>
                                                        <td>{{ $totalCHFinalFac }}</td>
                                                        <td>{{ $totalCBFinalFac }}</td>
                                                        <td>{{ $totalCLFinalFac }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttFac as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->h }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hFac }}</td>
                                                        <td>{{ $total_taFac }}</td>
                                                        <td>{{ $total_dFac }}</td>
                                                        <td>{{ $total_lFac }}</td>
                                                        <td>{{ $total_mFac }}</td>
                                                        <td>{{ $total_mxFac }}</td>
                                                        <td>{{ $total_sFac }}</td>
                                                        <td>{{ $total_sxFac }}</td>
                                                        <td>{{ $total_iFac }}</td>
                                                        <td>{{ $total_ipFac }}</td>
                                                        <td>{{ $total_ixFac }}</td>
                                                        <td>{{ $total_ctFac }}</td>
                                                        <td>{{ $total_chFac }}</td>
                                                        <td>{{ $total_cbFac }}</td>
                                                        <td>{{ $total_clFac }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>3. Data Kehadiran Perkemandoran</h4>
                                            <table class="table" id="table-data">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Mandor</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Status</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Total<br>TK</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="padding-left:8px;padding-right:8px;width: 80px;">TA</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="padding-left:0px;padding-right:0px;width: 80px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">M</th>
                                                        <th style="width: 80px;">MX</th>
                                                        <th style="padding-left:8px;padding-right:8px;width: 80px;">S</th>
                                                        <th style="width: 80px;">SX</th>
                                                        <th style="padding-left:16px;padding-right:16px;width: 80px;">I</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IP</th>
                                                        <th style="padding-left:12px;padding-right:12px;width: 80px;">IX</th>
                                                        <th style="width: 80px;">CT</th>
                                                        <th style="width: 80px;">CH</th>
                                                        <th style="width: 80px;">CB</th>
                                                        <th style="width: 80px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($dataFac as $item)
                                                        <tr class="text-left">
                                                            <td rowspan="4" style="text-align: center; vertical-align: middle;">{{ $counter++ }}</td>
                                                            <form action="{{ route('summary-per-dept-mandor-per-emp-for-dash') }}" method="POST">
                                                                @csrf
                                                                <td rowspan="4" class="text-left">
                                                                    <br>
                                                                    <input type="hidden" name="mandor_nik" value="{{ $item['mandor'] }}">
                                                                    <input type="hidden" name="date" value="{{ $item['date'] }}">
                                                                    <input type="hidden" name="dept" value="{{ $item['dept'] }}">
                                                                    {{ $item['mandorName'] }}
                                                                    <br><button class="btn btn-primary btn-sm" type="submit">Detail</button>
                                                                </td>
                                                            </form>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">Reg</td>
                                                            <td>{{ $item['regularTotal1Fac'] }}</td>
                                                            <td>{{ $item['totalHFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalDFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalLFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalMFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalSFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalIFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegFac'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegFac'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left text-bold">FL</td>
                                                            <td>{{ $item['flTotal1Fac'] }}</td>
                                                            <td>{{ $item['totalHFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalTAFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalDFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalLFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalMFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalMXFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalSFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalSXFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalIFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalIPFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalIXFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalCTFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalCHFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalCBFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalCLFinalFlFac'] }}</td>
                                                        </tr>
                                                        <tr style="background-color: #ffff99;">
                                                            <td class="text-left text-bold">Total</td>
                                                            <td>{{ $item['regularTotal1Fac'] + $item['flTotal1Fac'] }}</td>
                                                            <td>{{ $item['totalHFinalRegFac'] + $item['totalHFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalTAFinalRegFac'] + $item['totalTAFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalDFinalRegFac'] + $item['totalDFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalLFinalRegFac'] + $item['totalLFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalMFinalRegFac'] + $item['totalMFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalMXFinalRegFac'] + $item['totalMXFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalSFinalRegFac'] + $item['totalSFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalSXFinalRegFac'] + $item['totalSXFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalIFinalRegFac'] + $item['totalIFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalIPFinalRegFac'] + $item['totalIPFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalIXFinalRegFac'] + $item['totalIXFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalCTFinalRegFac'] + $item['totalCTFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalCHFinalRegFac'] + $item['totalCHFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalCBFinalRegFac'] + $item['totalCBFinalFlFac'] }}</td>
                                                            <td>{{ $item['totalCLFinalRegFac'] + $item['totalCLFinalFlFac'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td rowspan="4"></td>
                                                        <td rowspan="4" style="text-align: center; vertical-align: middle;">Total</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">Reg</td>
                                                        <td>{{ $totalRegularTotal1Fac }}</td>
                                                        <td>{{ $totalHTotalRegFac }}</td>
                                                        <td>{{ $totalTATotalRegFac }}</td>
                                                        <td>{{ $totalDTotalRegFac }}</td>
                                                        <td>{{ $totalLTotalRegFac }}</td>
                                                        <td>{{ $totalMTotalRegFac }}</td>
                                                        <td>{{ $totalMXTotalRegFac }}</td>
                                                        <td>{{ $totalSTotalRegFac }}</td>
                                                        <td>{{ $totalSXTotalRegFac }}</td>
                                                        <td>{{ $totalITotalRegFac }}</td>
                                                        <td>{{ $totalIPTotalRegFac }}</td>
                                                        <td>{{ $totalIXTotalRegFac }}</td>
                                                        <td>{{ $totalCTTotalRegFac }}</td>
                                                        <td>{{ $totalCHTotalRegFac }}</td>
                                                        <td>{{ $totalCBTotalRegFac }}</td>
                                                        <td>{{ $totalCLTotalRegFac }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left text-bold">FL</td>
                                                        <td>{{ $totalFlTotal1Fac }}</td>
                                                        <td>{{ $totalHTotalFlFac }}</td>
                                                        <td>{{ $totalTATotalFlFac }}</td>
                                                        <td>{{ $totalDTotalFlFac }}</td>
                                                        <td>{{ $totalLTotalFlFac }}</td>
                                                        <td>{{ $totalMTotalFlFac }}</td>
                                                        <td>{{ $totalMXTotalFlFac }}</td>
                                                        <td>{{ $totalSTotalFlFac }}</td>
                                                        <td>{{ $totalSXTotalFlFac }}</td>
                                                        <td>{{ $totalITotalFlFac }}</td>
                                                        <td>{{ $totalIPTotalFlFac }}</td>
                                                        <td>{{ $totalIXTotalFlFac }}</td>
                                                        <td>{{ $totalCTTotalFlFac }}</td>
                                                        <td>{{ $totalCHTotalFlFac }}</td>
                                                        <td>{{ $totalCBTotalFlFac }}</td>
                                                        <td>{{ $totalCLTotalFlFac }}</td>
                                                    </tr>
                                                    <tr style="background-color: #ffff99;">
                                                        <td class="text-left text-bold">Total</td>
                                                        <td>{{ $totalRegularTotal1Fac + $totalFlTotal1Fac }}</td>
                                                        <td>{{ $totalHTotalRegFac + $totalHTotalFlFac }}</td>
                                                        <td>{{ $totalTATotalRegFac + $totalTATotalFlFac }}</td>
                                                        <td>{{ $totalDTotalRegFac + $totalDTotalFlFac }}</td>
                                                        <td>{{ $totalLTotalRegFac + $totalLTotalFlFac }}</td>
                                                        <td>{{ $totalMTotalRegFac + $totalMTotalFlFac }}</td>
                                                        <td>{{ $totalMXTotalRegFac + $totalMXTotalFlFac }}</td>
                                                        <td>{{ $totalSTotalRegFac + $totalSTotalFlFac }}</td>
                                                        <td>{{ $totalSXTotalRegFac + $totalSXTotalFlFac }}</td>
                                                        <td>{{ $totalITotalRegFac + $totalITotalFlFac }}</td>
                                                        <td>{{ $totalIPTotalRegFac + $totalIPTotalFlFac }}</td>
                                                        <td>{{ $totalIXTotalRegFac + $totalIXTotalFlFac }}</td>
                                                        <td>{{ $totalCTTotalRegFac + $totalCTTotalFlFac }}</td>
                                                        <td>{{ $totalCHTotalRegFac + $totalCHTotalFlFac }}</td>
                                                        <td>{{ $totalCBTotalRegFac + $totalCBTotalFlFac }}</td>
                                                        <td>{{ $totalCLTotalRegFac + $totalCLTotalFlFac }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>

                        {{-- GA --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: GA</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalGA }}</td>
                                                        @if($staffAttGA->isEmpty())
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
                                                        @foreach ($staffAttGA as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalGA }}</td>
                                                        @if($monAttGA->isEmpty())
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
                                                        @foreach ($monAttGA as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalGA }}</td>
                                                        @if($regAttGA->isEmpty())
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
                                                        @foreach ($regAttGA as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalGA }}</td>
                                                        @if($bskpAttGA->isEmpty())
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
                                                        @foreach ($bskpAttGA as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalGA }}</td>
                                                        @if($flAttGA->isEmpty())
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
                                                        @foreach ($flAttGA as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalGA + $monthlyTotalGA + $regularTotalGA + $bskpTotalGA + $flTotalGA }}</td>
                                                        <td>{{ $totalHFinalGA }}</td>
                                                        <td>{{ $totalTAFinalGA }}</td>
                                                        <td>{{ $totalDFinalGA }}</td>
                                                        <td>{{ $totalLFinalGA }}</td>
                                                        <td>{{ $totalMFinalGA }}</td>
                                                        <td>{{ $totalMXFinalGA }}</td>
                                                        <td>{{ $totalSFinalGA }}</td>
                                                        <td>{{ $totalSXFinalGA }}</td>
                                                        <td>{{ $totalIFinalGA }}</td>
                                                        <td>{{ $totalIPFinalGA }}</td>
                                                        <td>{{ $totalIXFinalGA }}</td>
                                                        <td>{{ $totalCTFinalGA }}</td>
                                                        <td>{{ $totalCHFinalGA }}</td>
                                                        <td>{{ $totalCBFinalGA }}</td>
                                                        <td>{{ $totalCLFinalGA }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttGA as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hGA }}</td>
                                                        <td>{{ $total_taGA }}</td>
                                                        <td>{{ $total_dGA }}</td>
                                                        <td>{{ $total_lGA }}</td>
                                                        <td>{{ $total_mGA }}</td>
                                                        <td>{{ $total_mxGA }}</td>
                                                        <td>{{ $total_sGA }}</td>
                                                        <td>{{ $total_sxGA }}</td>
                                                        <td>{{ $total_iGA }}</td>
                                                        <td>{{ $total_ipGA }}</td>
                                                        <td>{{ $total_ixGA }}</td>
                                                        <td>{{ $total_ctGA }}</td>
                                                        <td>{{ $total_chGA }}</td>
                                                        <td>{{ $total_cbGA }}</td>
                                                        <td>{{ $total_clGA }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- HR Legal --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: HR Legal</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalHR }}</td>
                                                        @if($staffAttHR->isEmpty())
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
                                                        @foreach ($staffAttHR as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalHR }}</td>
                                                        @if($monAttHR->isEmpty())
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
                                                        @foreach ($monAttHR as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalHR }}</td>
                                                        @if($regAttHR->isEmpty())
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
                                                        @foreach ($regAttHR as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalHR }}</td>
                                                        @if($bskpAttHR->isEmpty())
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
                                                        @foreach ($bskpAttHR as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalHR }}</td>
                                                        @if($flAttHR->isEmpty())
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
                                                        @foreach ($flAttHR as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalHR + $monthlyTotalHR + $regularTotalHR + $bskpTotalHR + $flTotalHR }}</td>
                                                        <td>{{ $totalHFinalHR }}</td>
                                                        <td>{{ $totalTAFinalHR }}</td>
                                                        <td>{{ $totalDFinalHR }}</td>
                                                        <td>{{ $totalLFinalHR }}</td>
                                                        <td>{{ $totalMFinalHR }}</td>
                                                        <td>{{ $totalMXFinalHR }}</td>
                                                        <td>{{ $totalSFinalHR }}</td>
                                                        <td>{{ $totalSXFinalHR }}</td>
                                                        <td>{{ $totalIFinalHR }}</td>
                                                        <td>{{ $totalIPFinalHR }}</td>
                                                        <td>{{ $totalIXFinalHR }}</td>
                                                        <td>{{ $totalCTFinalHR }}</td>
                                                        <td>{{ $totalCHFinalHR }}</td>
                                                        <td>{{ $totalCBFinalHR }}</td>
                                                        <td>{{ $totalCLFinalHR }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttHR as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hHR }}</td>
                                                        <td>{{ $total_taHR }}</td>
                                                        <td>{{ $total_dHR }}</td>
                                                        <td>{{ $total_lHR }}</td>
                                                        <td>{{ $total_mHR }}</td>
                                                        <td>{{ $total_mxHR }}</td>
                                                        <td>{{ $total_sHR }}</td>
                                                        <td>{{ $total_sxHR }}</td>
                                                        <td>{{ $total_iHR }}</td>
                                                        <td>{{ $total_ipHR }}</td>
                                                        <td>{{ $total_ixHR }}</td>
                                                        <td>{{ $total_ctHR }}</td>
                                                        <td>{{ $total_chHR }}</td>
                                                        <td>{{ $total_cbHR }}</td>
                                                        <td>{{ $total_clHR }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- HSE & DP --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: HSE & DP</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalHSEDP }}</td>
                                                        @if($staffAttHSEDP->isEmpty())
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
                                                        @foreach ($staffAttHSEDP as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalHSEDP }}</td>
                                                        @if($monAttHSEDP->isEmpty())
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
                                                        @foreach ($monAttHSEDP as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalHSEDP }}</td>
                                                        @if($regAttHSEDP->isEmpty())
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
                                                        @foreach ($regAttHSEDP as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalHSEDP }}</td>
                                                        @if($bskpAttHSEDP->isEmpty())
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
                                                        @foreach ($bskpAttHSEDP as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalHSEDP }}</td>
                                                        @if($flAttHSEDP->isEmpty())
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
                                                        @foreach ($flAttHSEDP as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalHSEDP + $monthlyTotalHSEDP + $regularTotalHSEDP + $bskpTotalHSEDP + $flTotalHSEDP }}</td>
                                                        <td>{{ $totalHFinalHSEDP }}</td>
                                                        <td>{{ $totalTAFinalHSEDP }}</td>
                                                        <td>{{ $totalDFinalHSEDP }}</td>
                                                        <td>{{ $totalLFinalHSEDP }}</td>
                                                        <td>{{ $totalMFinalHSEDP }}</td>
                                                        <td>{{ $totalMXFinalHSEDP }}</td>
                                                        <td>{{ $totalSFinalHSEDP }}</td>
                                                        <td>{{ $totalSXFinalHSEDP }}</td>
                                                        <td>{{ $totalIFinalHSEDP }}</td>
                                                        <td>{{ $totalIPFinalHSEDP }}</td>
                                                        <td>{{ $totalIXFinalHSEDP }}</td>
                                                        <td>{{ $totalCTFinalHSEDP }}</td>
                                                        <td>{{ $totalCHFinalHSEDP }}</td>
                                                        <td>{{ $totalCBFinalHSEDP }}</td>
                                                        <td>{{ $totalCLFinalHSEDP }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttHSEDP as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hHSEDP }}</td>
                                                        <td>{{ $total_taHSEDP }}</td>
                                                        <td>{{ $total_dHSEDP }}</td>
                                                        <td>{{ $total_lHSEDP }}</td>
                                                        <td>{{ $total_mHSEDP }}</td>
                                                        <td>{{ $total_mxHSEDP }}</td>
                                                        <td>{{ $total_sHSEDP }}</td>
                                                        <td>{{ $total_sxHSEDP }}</td>
                                                        <td>{{ $total_iHSEDP }}</td>
                                                        <td>{{ $total_ipHSEDP }}</td>
                                                        <td>{{ $total_ixHSEDP }}</td>
                                                        <td>{{ $total_ctHSEDP }}</td>
                                                        <td>{{ $total_chHSEDP }}</td>
                                                        <td>{{ $total_cbHSEDP }}</td>
                                                        <td>{{ $total_clHSEDP }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- IT --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: IT</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalIT }}</td>
                                                        @if($staffAttIT->isEmpty())
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
                                                        @foreach ($staffAttIT as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalIT }}</td>
                                                        @if($monAttIT->isEmpty())
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
                                                        @foreach ($monAttIT as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalIT }}</td>
                                                        @if($regAttIT->isEmpty())
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
                                                        @foreach ($regAttIT as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalIT }}</td>
                                                        @if($bskpAttIT->isEmpty())
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
                                                        @foreach ($bskpAttIT as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalIT }}</td>
                                                        @if($flAttIT->isEmpty())
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
                                                        @foreach ($flAttIT as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalIT + $monthlyTotalIT + $regularTotalIT + $bskpTotalIT + $flTotalIT }}</td>
                                                        <td>{{ $totalHFinalIT }}</td>
                                                        <td>{{ $totalTAFinalIT }}</td>
                                                        <td>{{ $totalDFinalIT }}</td>
                                                        <td>{{ $totalLFinalIT }}</td>
                                                        <td>{{ $totalMFinalIT }}</td>
                                                        <td>{{ $totalMXFinalIT }}</td>
                                                        <td>{{ $totalSFinalIT }}</td>
                                                        <td>{{ $totalSXFinalIT }}</td>
                                                        <td>{{ $totalIFinalIT }}</td>
                                                        <td>{{ $totalIPFinalIT }}</td>
                                                        <td>{{ $totalIXFinalIT }}</td>
                                                        <td>{{ $totalCTFinalIT }}</td>
                                                        <td>{{ $totalCHFinalIT }}</td>
                                                        <td>{{ $totalCBFinalIT }}</td>
                                                        <td>{{ $totalCLFinalIT }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttIT as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hIT }}</td>
                                                        <td>{{ $total_taIT }}</td>
                                                        <td>{{ $total_dIT }}</td>
                                                        <td>{{ $total_lIT }}</td>
                                                        <td>{{ $total_mIT }}</td>
                                                        <td>{{ $total_mxIT }}</td>
                                                        <td>{{ $total_sIT }}</td>
                                                        <td>{{ $total_sxIT }}</td>
                                                        <td>{{ $total_iIT }}</td>
                                                        <td>{{ $total_ipIT }}</td>
                                                        <td>{{ $total_ixIT }}</td>
                                                        <td>{{ $total_ctIT }}</td>
                                                        <td>{{ $total_chIT }}</td>
                                                        <td>{{ $total_cbIT }}</td>
                                                        <td>{{ $total_clIT }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- QA & QM --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: QA & QM</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalQAQM }}</td>
                                                        @if($staffAttQAQM->isEmpty())
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
                                                        @foreach ($staffAttQAQM as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalQAQM }}</td>
                                                        @if($monAttQAQM->isEmpty())
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
                                                        @foreach ($monAttQAQM as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalQAQM }}</td>
                                                        @if($regAttQAQM->isEmpty())
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
                                                        @foreach ($regAttQAQM as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalQAQM }}</td>
                                                        @if($bskpAttQAQM->isEmpty())
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
                                                        @foreach ($bskpAttQAQM as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalQAQM }}</td>
                                                        @if($flAttQAQM->isEmpty())
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
                                                        @foreach ($flAttQAQM as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalQAQM + $monthlyTotalQAQM + $regularTotalQAQM + $bskpTotalQAQM + $flTotalQAQM }}</td>
                                                        <td>{{ $totalHFinalQAQM }}</td>
                                                        <td>{{ $totalTAFinalQAQM }}</td>
                                                        <td>{{ $totalDFinalQAQM }}</td>
                                                        <td>{{ $totalLFinalQAQM }}</td>
                                                        <td>{{ $totalMFinalQAQM }}</td>
                                                        <td>{{ $totalMXFinalQAQM }}</td>
                                                        <td>{{ $totalSFinalQAQM }}</td>
                                                        <td>{{ $totalSXFinalQAQM }}</td>
                                                        <td>{{ $totalIFinalQAQM }}</td>
                                                        <td>{{ $totalIPFinalQAQM }}</td>
                                                        <td>{{ $totalIXFinalQAQM }}</td>
                                                        <td>{{ $totalCTFinalQAQM }}</td>
                                                        <td>{{ $totalCHFinalQAQM }}</td>
                                                        <td>{{ $totalCBFinalQAQM }}</td>
                                                        <td>{{ $totalCLFinalQAQM }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttQAQM as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hQAQM }}</td>
                                                        <td>{{ $total_taQAQM }}</td>
                                                        <td>{{ $total_dQAQM }}</td>
                                                        <td>{{ $total_lQAQM }}</td>
                                                        <td>{{ $total_mQAQM }}</td>
                                                        <td>{{ $total_mxQAQM }}</td>
                                                        <td>{{ $total_sQAQM }}</td>
                                                        <td>{{ $total_sxQAQM }}</td>
                                                        <td>{{ $total_iQAQM }}</td>
                                                        <td>{{ $total_ipQAQM }}</td>
                                                        <td>{{ $total_ixQAQM }}</td>
                                                        <td>{{ $total_ctQAQM }}</td>
                                                        <td>{{ $total_chQAQM }}</td>
                                                        <td>{{ $total_cbQAQM }}</td>
                                                        <td>{{ $total_clQAQM }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Security --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: Security</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalSec }}</td>
                                                        @if($staffAttSec->isEmpty())
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
                                                        @foreach ($staffAttSec as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalSec }}</td>
                                                        @if($monAttSec->isEmpty())
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
                                                        @foreach ($monAttSec as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalSec }}</td>
                                                        @if($regAttSec->isEmpty())
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
                                                        @foreach ($regAttSec as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalSec }}</td>
                                                        @if($bskpAttSec->isEmpty())
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
                                                        @foreach ($bskpAttSec as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalSec }}</td>
                                                        @if($flAttSec->isEmpty())
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
                                                        @foreach ($flAttSec as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalSec + $monthlyTotalSec + $regularTotalSec + $bskpTotalSec + $flTotalSec }}</td>
                                                        <td>{{ $totalHFinalSec }}</td>
                                                        <td>{{ $totalTAFinalSec }}</td>
                                                        <td>{{ $totalDFinalSec }}</td>
                                                        <td>{{ $totalLFinalSec }}</td>
                                                        <td>{{ $totalMFinalSec }}</td>
                                                        <td>{{ $totalMXFinalSec }}</td>
                                                        <td>{{ $totalSFinalSec }}</td>
                                                        <td>{{ $totalSXFinalSec }}</td>
                                                        <td>{{ $totalIFinalSec }}</td>
                                                        <td>{{ $totalIPFinalSec }}</td>
                                                        <td>{{ $totalIXFinalSec }}</td>
                                                        <td>{{ $totalCTFinalSec }}</td>
                                                        <td>{{ $totalCHFinalSec }}</td>
                                                        <td>{{ $totalCBFinalSec }}</td>
                                                        <td>{{ $totalCLFinalSec }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttSec as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hSec }}</td>
                                                        <td>{{ $total_taSec }}</td>
                                                        <td>{{ $total_dSec }}</td>
                                                        <td>{{ $total_lSec }}</td>
                                                        <td>{{ $total_mSec }}</td>
                                                        <td>{{ $total_mxSec }}</td>
                                                        <td>{{ $total_sSec }}</td>
                                                        <td>{{ $total_sxSec }}</td>
                                                        <td>{{ $total_iSec }}</td>
                                                        <td>{{ $total_ipSec }}</td>
                                                        <td>{{ $total_ixSec }}</td>
                                                        <td>{{ $total_ctSec }}</td>
                                                        <td>{{ $total_chSec }}</td>
                                                        <td>{{ $total_cbSec }}</td>
                                                        <td>{{ $total_clSec }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Workshop --}}
                        <div class="card mx-3 my-3">
                            <div class="">
                                <div class="">
                                    <div class="card-header">
                                        <h3><strong></strong></h3>
                                    </div>
                                    <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Dept: Workshop</h4>
                                                    <button class="btn btn-success btn-sm" id="btn-d">Export Excel</button>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%" style="float: right"><br>
                                                    <p style="margin-bottom:0px;">Periode Tgl: {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                                                    <p>Jam: {{ $latestUpdatedAtDateTime }}</p>
                                                </div>
                                            </div>
                                            <h4>1. Data Kehadiran Per Dept / Sub Div</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 120px;">Status</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 77px;">Total TK</th>
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
                                                        <td>{{ $staffTotalWs }}</td>
                                                        @if($staffAttWs->isEmpty())
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
                                                        @foreach ($staffAttWs as $staff)
                                                            <td>{{ $staff->hadir }}</td>
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
                                                        <td>{{ $monthlyTotalWs }}</td>
                                                        @if($monAttWs->isEmpty())
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
                                                        @foreach ($monAttWs as $mon)
                                                            <td>{{ $mon->hadir }}</td>
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
                                                        <td>{{ $regularTotalWs }}</td>
                                                        @if($regAttWs->isEmpty())
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
                                                        @foreach ($regAttWs as $reg)
                                                            <td>{{ $reg->hadir }}</td>
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
                                                        <td>{{ $bskpTotalWs }}</td>
                                                        @if($bskpAttWs->isEmpty())
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
                                                        @foreach ($bskpAttWs as $bskp)
                                                            <td>{{ $bskp->hadir }}</td>
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
                                                        <td>{{ $flTotalWs }}</td>
                                                        @if($flAttWs->isEmpty())
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
                                                        @foreach ($flAttWs as $fl)
                                                            <td>{{ $fl->hadir }}</td>
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
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $staffTotalWs + $monthlyTotalWs + $regularTotalWs + $bskpTotalWs + $flTotalWs }}</td>
                                                        <td>{{ $totalHFinalWs }}</td>
                                                        <td>{{ $totalTAFinalWs }}</td>
                                                        <td>{{ $totalDFinalWs }}</td>
                                                        <td>{{ $totalLFinalWs }}</td>
                                                        <td>{{ $totalMFinalWs }}</td>
                                                        <td>{{ $totalMXFinalWs }}</td>
                                                        <td>{{ $totalSFinalWs }}</td>
                                                        <td>{{ $totalSXFinalWs }}</td>
                                                        <td>{{ $totalIFinalWs }}</td>
                                                        <td>{{ $totalIPFinalWs }}</td>
                                                        <td>{{ $totalIXFinalWs }}</td>
                                                        <td>{{ $totalCTFinalWs }}</td>
                                                        <td>{{ $totalCHFinalWs }}</td>
                                                        <td>{{ $totalCBFinalWs }}</td>
                                                        <td>{{ $totalCLFinalWs }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br><hr><br>
                                            <h4>2. Data Kehadiran Staff & Monthly</h4>
                                            <table id="table-data">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 30px;">No</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 225px;">Nama</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Hadir<br>(H)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">TA</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Dinas<br>(D)</th>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;width: 70px;">Lambat<br>(L)<br>Day</th>
                                                        <th colspan="2">Mangkir (M)</th>
                                                        <th colspan="2">Sakit (S)</th>
                                                        <th colspan="3">Ijin (I)</th>
                                                        <th colspan="4">Cuti (C)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">M</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">MX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">S</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">SX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">I</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IP</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">IX</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CT</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CH</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CB</th>
                                                        <th style="text-align: center; vertical-align: middle;width: 70px;">CL</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($empAttWs as $item)
                                                        <tr  class="text-center">
                                                            <td>{{ $counter++ }}</td>
                                                            <td class="text-left">{{ $item->name }}</td>
                                                            <td>{{ $item->hadir }}</td>
                                                            <td>{{ $item->ta }}</td>
                                                            <td>{{ $item->d }}</td>
                                                            <td>{{ $item->l }}</td>
                                                            <td>{{ $item->m }}</td>
                                                            <td>{{ $item->mx }}</td>
                                                            <td>{{ $item->s }}</td>
                                                            <td>{{ $item->sx }}</td>
                                                            <td>{{ $item->i }}</td>
                                                            <td>{{ $item->ip }}</td>
                                                            <td>{{ $item->ix }}</td>
                                                            <td>{{ $item->ct }}</td>
                                                            <td>{{ $item->ch }}</td>
                                                            <td>{{ $item->cb }}</td>
                                                            <td>{{ $item->cl }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center" style="background-color: #ffff99;">
                                                        <td colspan="2">Total</td>
                                                        <td>{{ $total_hWs }}</td>
                                                        <td>{{ $total_taWs }}</td>
                                                        <td>{{ $total_dWs }}</td>
                                                        <td>{{ $total_lWs }}</td>
                                                        <td>{{ $total_mWs }}</td>
                                                        <td>{{ $total_mxWs }}</td>
                                                        <td>{{ $total_sWs }}</td>
                                                        <td>{{ $total_sxWs }}</td>
                                                        <td>{{ $total_iWs }}</td>
                                                        <td>{{ $total_ipWs }}</td>
                                                        <td>{{ $total_ixWs }}</td>
                                                        <td>{{ $total_ctWs }}</td>
                                                        <td>{{ $total_chWs }}</td>
                                                        <td>{{ $total_cbWs }}</td>
                                                        <td>{{ $total_clWs }}</td>
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
