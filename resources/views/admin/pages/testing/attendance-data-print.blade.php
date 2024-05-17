<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* @page { margin: 5px; } */
        /* body { margin: 5px; } */
        @font-face {
            font-family: 'arial-narrow';
            src: local('arial-narrow'), url('{{ asset('fonts/arial-narrow.tff') }}') format('tff');
            font-weight: normal;
            font-style: normal;
        }

        .judul {
            margin: 1px;
            text-align: left;
            font-size: 20px;
            font-family: 'arial-narrow', sans-serif;
        }

        .sub-judul {
            margin: 1px;
            text-align: left;
            font-size: 15px;
            font-family: 'arial-narrow', sans-serif;
        }

        table, td, th {
            border: 1px solid;
            font-family: 'arial-narrow', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'arial-narrow', sans-serif;
        }

        tfoot {
            text-align: center;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-biodata {
            border: 1px solid;
            width: 20%;
            border-collapse: collapse;
            padding-bottom: 5px;
            padding-top: 10px;
            float: left;
            font-size: 10px;
            font-family: 'arial-narrow', sans-serif;
            /* margin-right: 800px; */
        }

        #tb-biodata td {
            padding-left: 5px;
            border-color: #201515;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-biodata th {
            background-color: #201515;
            text-align: center;
            color: #ffffff;
            border-color: #201515;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-ket {
            border: 1px solid;
            width: 40%;
            border-collapse: collapse;
            text-align: center;
            padding-bottom: 5px;
            float: right;
            font-size: 5px;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-ket td {
            padding-left: 5px;
            border-color: #201515;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-ket th {
            background-color: #201515;
            text-align: center;
            color: #ffffff;
            border-color: #201515;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-hkb {
            padding-top: 70px;
            padding-right: 145px;
            border: 1px solid;
            width: 20%;
            float: right;
            border-collapse: collapse;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-hkb td {
            padding-left: 5px;
            border-color: #201515;
            font-family: 'arial-narrow', sans-serif;
            font-size: 15px;
            text-align: center;
        }

        #tb-hkb th {
            background-color: #201515;
            text-align: center;
            color: #ffffff;
            border-color: #201515;
            font-family: 'arial-narrow', sans-serif;
            font-size: 8px;
        }

        #tb-hk {
            padding-top: 70px;
            border: 1px solid;
            width: 12%;
            float: right;
            border-collapse: collapse;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-hk td {
            padding-left: 5px;
            border-color: #201515;
            font-family: 'arial-narrow', sans-serif;
            font-size: 15px;
            text-align: center;
        }

        #tb-hk th {
            background-color: #201515;
            text-align: center;
            color: #ffffff;
            border-color: #201515;
            font-family: 'arial-narrow', sans-serif;
            font-size: 8px;
            text-align: center;
        }

        .clear {
            clear: both;
        }

        #tb-attendance {
            padding-top: 5px;
            border: 1px solid;
            width: 100%;
            border-collapse: collapse;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-attendance th {
            border-color:#343a40;
            color:#201515;
            font-size: 10px;
            font-family: 'arial-narrow', sans-serif;
        }

        .hari {
            padding-right: 0px;
            text-align: center;
            font-size: 10px;
            font-family: 'arial-narrow', sans-serif;
        }

        .tjk {
            padding: 0px;
            font-family: 'arial-narrow', sans-serif;
        }

        .ket {
            padding-left: 0px;
            padding-right: 0px;
            font-size: 10px;
            font-family: 'arial-narrow', sans-serif;
        }

    </style>
</head>
<body>
    <p class="judul">Laporan Kehadiran Detail Harian</p>
    <p class="sub-judul">Periode:
        @if ($firstDay == null && $lastDay == null)
            {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d M, Y') }}
        @else
            {{ $firstDay }} to {{ $lastDay }}
        @endif
    </p>
    <table id="tb-biodata">
        <thead>
            <tr>
                <th colspan="2">Biodata</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>NIK</td>
                <td>{{ $emp->nik }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $emp->name }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>{{ $emp->status }}</td>
            </tr>
            <tr>
                <td>Dept</td>
                <td>{{ $emp->dept }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>{{ $emp->jabatan }}</td>
            </tr>
        </tbody>
    </table>
    <table id="tb-ket">
        <thead>
            <tr>
                <th colspan="3">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>OT (Lembur)</td>
                <td>H (Hadir)</td>
                <td>L (Lambat)</td>
            </tr>
            <tr>
                <td>TA (Tidak Absen)</td>
                <td>M (Mangkir)</td>
                <td>MX (Mangkir Hari Libur)</td>
            </tr>
            <tr>
                <td>I (Izin)</td>
                <td>IP (Izin Pribadi)</td>
                <td>IX (Izin Tidak Dibayar)</td>
            </tr>
            <tr>
                <td>S (Sakit)</td>
                <td>SX (Sakit Tidak Dibayar)</td>
                <td>CT (Cuti Tahunan)</td>
            </tr>
            <tr>
                <td>CH (Cuti Melahirkan)</td>
                <td>CL (Cuti Lain-lain)</td>
                <td>CB (Cuti Besar)</td>
            </tr>
            <tr>
                <td></td>
                <td>D (Dinas)</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table id="tb-hkb" class="clear">
        <thead>
            <tr>
                <th>Total Hari ({{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('F') }})</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $totalDaysWithData }}</td>
            </tr>
        </tbody>
    </table>
    <table id="tb-hk" class="clear">
        <thead>
            <tr>
                <th>Total Hari Kerja / Total Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $totalDaysWithoutMXData }} / {{ $emp1_total->h + $emp1_total->ta + $emp1_total->d + $emp1_total->l + $emp1_total->s + $emp1_total->i + $emp1_total->ip + $emp1_total->ct + $emp1_total->ch + $emp1_total->cb + $emp1_total->cl }}</td>
            </tr>
        </tbody>
    </table>
    <table id="tb-attendance" class="clear">
        <thead>
            <tr>
                <th rowspan="2">Hari/Tanggal</th>
                <th colspan="2">Absen Masuk</th>
                <th colspan="2">Absen Pulang</th>
                <th rowspan="2">Total <br> Jam <br> Kerja</th>
                <th rowspan="2">OT</th>
                <th rowspan="2">H</th>
                <th rowspan="2">TA</th>
                <th rowspan="2">D</th>
                <th colspan="4">L</th>
                <th colspan="4">M</th>
                <th colspan="4">S</th>
                <th colspan="6">I</th>
                <th colspan="8">C</th>
                <th rowspan="2">Ket</th>
            </tr>
            <tr>
                <th>Lokasi <br> Absen</th>
                <th>Jam <br> Masuk</th>
                <th>Lokasi <br> Absen</th>
                <th>Jam <br> Keluar</th>
                <th colspan="2">Day</th>
                <th colspan="2">Hour</th>
                <th colspan="2" style="padding-left: 8px;">M&nbsp;</th>
                <th colspan="2">MX</th>
                <th colspan="2" style="padding-left: 8px;">S&nbsp;</th>
                <th colspan="2">SX</th>
                <th colspan="2" style="padding-left: 7px;">I&nbsp;</th>
                <th colspan="2">IP</th>
                <th colspan="2">IX</th>
                <th colspan="2">CT</th>
                <th colspan="2">CH</th>
                <th colspan="2">CB</th>
                <th colspan="2">CL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $rowCount = 0;
            @endphp

            @foreach ($emp1 as $item)
            @php
                $rowColor = $rowCount % 2 == 0 ? 'background-color: #f0f0f0;' : 'background-color: #D1D0D1;';
                $locStartWork = $item->start_work_info;
                $locEndWork = $item->end_work_info;
            @endphp
            <tr style="{{ $rowColor }}" class="hari">
                {{-- Tanggal --}}
                <td>
                    {{ Carbon\Carbon::parse($item->date)->translatedFormat('D, d-M-y') }}
                </td>

                {{-- lokasi Absen --}}
                @if ($locStartWork == "FIO66206022260004")
                    <td>FAC</td>
                @elseif ($locStartWork == "FIO66208023070030")
                    <td>HO</td>
                @elseif ($locStartWork == "FIO66208023190896" || $locEndWork == "Fio66208023190896")
                    <td>WS</td>
                @elseif ($locStartWork == "FIO66208023190729")
                    <td>I/B</td>
                @elseif ($locStartWork == "FIO66208023190194")
                    <td>II/D</td>
                @else
                    <td>-</td>
                @endif

                {{-- Jam masuk --}}
                @if ($item->masuk == null)
                    <td>-</td>
                @else
                    <td>
                        {{ Carbon\Carbon::parse($item->masuk)->format('H:i') }}
                    </td>
                @endif

                {{-- lokasi Absen --}}
                @if ($locEndWork == "FIO66206022260004")
                    <td>FAC</td>
                @elseif ($locEndWork == "FIO66208023070030")
                    <td>HO</td>
                @elseif ($locEndWork == "FIO66208023190896" || $locEndWork == "Fio66208023190896")
                    <td>WS</td>
                @elseif ($locEndWork == "FIO66208023190729")
                    <td>I/B</td>
                @elseif ($locEndWork == "FIO66208023190194")
                    <td>II/D</td>
                @else
                    <td>-</td>
                @endif

                {{-- Jam Keluar --}}
                @if ($item->pulang == null)
                    <td>-</td>
                @else
                    <td>{{ Carbon\Carbon::parse($item->pulang)->format('H:i') }}</td>
                @endif

                {{-- Total Jam Kerja --}}
                @if ($item->total_hour == null || $item->total_minute == null)
                    <td>-</td>
                @else
                    <td >{{ $item->total_hour}}:{{ $item->total_minute }}</td>
                @endif

                @php
                    $totalSum = 0;
                @endphp

                {{-- OT --}}
                @if ($item->overtime_hour == null && $item->overtime_minute == null)
                    <td>-</td>
                @elseif ($item->overtime_hour <= 0 && $item->overtime_minute <= 0)
                    <td>-</td>
                @else
                    <td>{{ $item->overtime_hour ?? 0 }}:{{ $item->overtime_minute ?? 0 }}</td>
                @endif
                {{-- <td>{{ $item->overtime_hour }}:{{ $item->overtime_minute ?? 0 }}</td> --}}

                {{-- H --}}
                @if ($item->hadir == 1)
                    <td>I</td>
                @else
                    <td>0</td>
                @endif

                {{-- TA --}}
                @if ($item->desc == 'TA')
                    <td>I</td>
                @else
                    <td>0</td>
                @endif

                {{-- D --}}
                @if ($item->desc == 'D')
                    <td style="padding-left: 10px; text-align: left;">&nbsp;I</td>
                @else
                    <td style="padding-left: 10px; text-align: left;">&nbsp;0</td>
                @endif

                {{-- L --}}
                @if ($item->desc == 'L')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                @if ($item->late_hour == null && $item->late_minute == null)
                    <td colspan="2">0</td>
                @else
                    <td colspan="2">{{ $item->late_hour }}:{{ $item->late_minute }}</td>
                @endif

                {{-- M --}}
                @if ($item->desc == 'M')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- MX --}}
                @if ($item->desc == 'MX' && $item->hadir == 0)
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- S --}}
                @if ($item->desc == 'S')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- SX --}}
                @if ($item->desc == 'SX')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- I --}}
                @if ($item->desc == 'I')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- IP --}}
                @if ($item->desc == 'IP')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- IX --}}
                @if ($item->desc == 'IX')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif


                {{-- CT --}}
                @if ($item->desc == 'CT')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- CH --}}
                @if ($item->desc == 'CH')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- CB --}}
                @if ($item->desc == 'CB')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- CL --}}
                @if ($item->desc == 'CL')
                    <td colspan="2">I</td>
                @else
                    <td colspan="2">0</td>
                @endif

                {{-- Keterangan --}}
                @if ($item->info == null)
                    <td colspan="1">-</td>
                @else
                    <td colspan="1">{{ $item->info }}</td>
                @endif

            </tr>
            @php
                $rowCount++;
            @endphp
            @endforeach
        </tbody>
        @php
        $tjkmtoHour = $emp1_total->tjkm / 60;
        $tothtoHour = $emp1_total->totm / 60;
        @endphp
        <tfoot style="font-size: 12px;">
            <tr>
                <td>Total Hari: {{ $totalDaysWithData }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ number_format($emp1_total->tjkx += $tjkmtoHour) }} Jam</td>
                <td>{{ number_format($emp1_total->toth += $tothtoHour) }} Jam</td>
                <td>{{ $emp1_total->hadir }}</td>
                <td>{{ $emp1_total->ta }}</td>
                <td>{{ $emp1_total->d }}</td>
                <td colspan="2">{{ $emp1_total->l }}</td>
                <td colspan="2">{{ round($totalLateHourEnd, 1) }} Jam</td>
                <td colspan="2">{{ $emp1_total->m }}</td>
                <td colspan="2">{{ $emp1_total->mx }}</td>
                <td colspan="2">{{ $emp1_total->s }}</td>
                <td colspan="2">{{ $emp1_total->sx }}</td>
                <td colspan="2">{{ $emp1_total->i }}</td>
                <td colspan="2">{{ $emp1_total->ip }}</td>
                <td colspan="2">{{ $emp1_total->ix }}</td>
                <td colspan="2">{{ $emp1_total->ct }}</td>
                <td colspan="2">{{ $emp1_total->cb }}</td>
                <td colspan="2">{{ $emp1_total->ch }}</td>
                <td colspan="2">{{ $emp1_total->cl }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
