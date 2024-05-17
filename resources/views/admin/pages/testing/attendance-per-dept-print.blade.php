<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Kehadiran Departement - {{ $dept }} - {{ $monthLabel }} - {{ $yearNow }}</title>
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
            text-align: left;
            font-size: 15px;
            margin: 1px;
            float: left;
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

        #tb-ket {
            border: 1px solid;
            width: 40%;
            border-collapse: collapse;
            text-align: center;
            padding-bottom: 5px;
            padding-top: 1px;
            float: right;
            font-size: 5px;
            font-family: 'arial-narrow', sans-serif;
        }

        .clear {
            clear: both;
        }

        #tb-ket td {
            padding-left: 1px;
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

        #tb-kehadiran {
            font-size: 10px;
            border-collapse: collapse;
            font-family: 'arial-narrow', sans-serif;
        }

        #tb-kehadiran tbody {
            height: 0%;
            text-align: center;
            font-family: 'arial-narrow', sans-serif;
        }

    </style>
</head>
<body>
    <p class="judul"><span style="font-style: bold;">Laporan Kehadiran Departement - {{ $dept }}</span> <br> <span style="font-size: 10px;">{{ $monthLabel }} - {{ $yearNow }} ({{ $totalDay }} Hari)</span></p>
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
                <td>D (Dinas)</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table id="tb-kehadiran" class="clear">
        <thead>
            <tr>
                <th rowspan="2">Kode Emp</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Jabatan</th>
                <th rowspan="2">Total <br>Jam Kerja</th>
                <th rowspan="2">OT</th>
                <th rowspan="2">H</th>
                <th rowspan="2">TA</th>
                <th rowspan="2">D</th>
                <th colspan="2">L</th>
                <th colspan="2">M</th>
                <th colspan="2">S</th>
                <th colspan="3">I</th>
                <th colspan="4">C</th>
                <th rowspan="2">Total Hari / Kehadiran</th>
            </tr>
            <tr>
                <th style="padding-left:28px; text-align:left">L</th>
                <th>Hours</th>
                <th style="padding-right:8px ;text-align:right">M</th>
                <th>MX</th>
                <th>S</th>
                <th>SX</th>
                <th>I</th>
                <th>IP</th>
                <th>IX</th>
                <th>CT</th>
                <th>CH</th>
                <th>CB</th>
                <th>CL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $rowCount = 0;
            @endphp

            @foreach ($emp1 as $key => $item)
                @php
                    $rowColor = $rowCount % 2 == 0 ? 'background-color: #f0f0f0;' : 'background-color: #D1D0D1;';
                @endphp
                <tr style="{{ $rowColor }}">
                    {{-- <td style="padding: 0; margin: 0;">{{ $item->nik }}</td> --}}
                    <td style="padding: 0; margin: 0;"><a href="{{ route('view-summary-emp-testing', $item->nik) }}">{{ $item->nik }}</a></td>
                    <td style="padding: 0; margin: 0; text-align: left; padding-left:5px;">{{ $item->name }}</td>
                    <td style="padding: 0; margin: 0;">{{ $item->status }}</td>
                    <td style="padding: 0; margin: 0;">{{ $item->jabatan }}</td>
                    @php
                        $day = $item->l + $item->h + $item->ta;
                        $tjk_sum = number_format($item->tjk, 2);
                        $shift_sum = number_format($item->shift - $day, 2);
                        $ot_sum = number_format($item->shift - $day, 2);
                        $jam = $item->tjkx;
                        $menit = $item->tjkm/60;
                        $detik = $item->tjks/3600;
                        $total_jam_kerja = $jam+$menit;
                        $tjkmtoHour = $item->tmin / 60;
                        $tothtoHour = $item->otmin / 60;
                        $latemintoHour = $item->latemin / 60;
                    @endphp
                    @if ($item->thour == 0 || $item->tmin == 0)
                        <td style="padding: 0; margin: 0;">0</td>
                    @else
                        <td style="padding: 0; margin: 0;">{{ number_format($item->thour += $tjkmtoHour) }} Jam</td>
                    @endif
                    @php
                        $late_jam = $item->late;
                        $late_menit = $item->latem/60;
                        $late_detik = $item->lates/3600;
                        $total_late = $late_jam+$late_menit+$late_detik;

                        $ot = number_format($tjk_sum - $shift_sum, 2);
                        $ots = number_format($ot - $total_late, 2);
                        $otl = $ots < 0 ? 0 : $ots;
                    @endphp
                    @if ($item->othour == 0 || $item->otmin == 0)
                        <td style="padding: 0; margin: 0;">0 Jam</td>
                    @else
                        <td style="padding: 0; margin: 0;">{{ number_format($item->othour += $tothtoHour, 1) }} Jam</td>
                    @endif
                    <td style="padding: 0; margin: 0; padding-left:8px ; text-align: left;">{{ $item->hadir }}</td>
                    <td style="padding: 0; margin: 0; text-align: center;">{{ $item->ta }}</td>
                    <td style="padding: 0; margin: 0; padding-left:8px ; text-align: left;">{{ $item->d }}</td>
                    <td style="padding: 0; margin: 0;padding-left:30px ; text-align: left;">{{ $item->l }}</td>
                    @if ($item->l == 0)
                        <td style="padding: 0; margin: 0; text-align: center;">0 Jam</td>
                    @else
                        <td style="padding: 0; margin: 0; text-align: center;">{{ round($item->latehour += $latemintoHour, 1) }} Jam</td>
                    @endif
                    <td style="padding: 0; margin: 0; padding-right:9px; text-align:right;">{{ $item->m }}</td>
                    <td style="padding: 0; margin: 0; text-align: center;">{{ $item->mx }}</td>
                    {{-- <td style="padding: 0; margin: 0; text-align: center;">7</td> --}}
                    <td style="padding: 0; margin: 0; padding-right:9px; text-align:right;">{{ $item->s }}</td>
                    <td style="padding: 0; margin: 0; text-align: center;">{{ $item->sx }}</td>
                    <td style="padding: 0; margin: 0; padding-right:9px; text-align:right;">{{ $item->i }}</td>
                    <td style="padding: 0; margin: 0; text-align: center;">{{ $item->ip }}</td>
                    <td style="padding: 0; margin: 0; text-align: center;">{{ $item->ix }}</td>
                    <td style="padding: 0; margin: 0; text-align: center;">{{ $item->ct }}</td>
                    <td style="padding: 0; margin: 0; text-align: center;">{{ $item->ch }}</td>
                    <td style="padding: 0; margin: 0; text-align: center;">{{ $item->cb }}</td>
                    <td style="padding: 0; margin: 0; text-align: center;">{{ $item->cl }}</td>
                    @php
                        $totalAtt = $item->h + $item->s + $item->i + $item->d + $item->ip + $item->ct + $item->ch + $item->cb + $item->cl + $item->l + $item->ta;
                        // $totalAtt = $item->h + $item->l +  $item->ta +  $item->d +  $item->m +  $item->mx +  $item->s +  $item->sx +  $item->i +  $item->ip +  $item->ix +  $item->ct +  $item->ch +  $item->cb +  $item->cl;
                        // $totalAtt = $item->hadir;
                    @endphp
                    <td style="padding: 0; margin: 0;">{{ $totalDay }} Hari / {{ $totalAtt }} Hari</td>
                </tr>
                @php
                    $rowCount++;
                @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
