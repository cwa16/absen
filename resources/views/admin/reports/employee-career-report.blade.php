<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
     body {
        font-size: 11px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .container {
        size: a4;
    }

    .table-1,
    .table-2,
    .table-3,
    .table-4,
    .table-5 {
        border-collapse: collapse;
    }

    .td-2 {
        border: 1px solid #000000;
    }


    .pt {
        font-size: 15px;
    }

    .black-bg {
        background: rgb(211, 211, 211);
        color: balck;
        height: 30px;
    }

    .box-small {
        height: 25px;
    }


    .text-kanan {
        float: right;
    }

    .text-tengah {
        text-align: center;
    }

    .text-kiri {
        text-align: left;
    }

    .table-2,
    .table-3,
    .table-4,
    .table-5 {
        margin-top: 15px;
    }

    .g-kiri {
        width: px;
    }

    .signature {
        vertical-align: top;
    }

    .bold {
        font-weight: bold;
    }

    .box {
        height: 80px;
    }
</style>

<body>
    <div class="container">
        <table class="table-1">
            <tr>
                <td style="width: 350px"><img src="{{ $image }}" alt="tt" width="250px"></td>
                <td style="width: 350px">
                    <div class="text-kanan"><u><b>RIWAYAT KERJA DI BSKP</b></u></div>
                </td>
            </tr>
            <tr>
                <td class="td-1">
                    <div class="text-kiri pt">PT. Bridgestone Kalimantan Plantation</div>
                </td>
                <td class="td-1">
                    <div class="text-kanan"><b>TODATE YEAR {{ $year }}</b></div>
                </td>
            </tr>
            <tr>
                <td class="td-1"></td>
                <td class="td-1">

                </td>
            </tr>
        </table>

        <table class="table-1">
            <tr>
                <th class="text-kiri">NIK</th>
                <th class="text-kiri">: {{ $emp->nik }}</th>
            </tr>
            <tr>
                <th class="text-kiri">Nama</th>
                <th class="text-kiri">: {{ $emp->name }}</th>
            </tr>
            <tr>
                <th class="text-kiri">Mulai Kerja</th>
                <th class="text-kiri">: {{ \Carbon\Carbon::parse($emp->start)->format('d-M-Y') }}</th>
            </tr>
        </table>

        <table class="table-1">
            <thead>
                <tr class="td-2">
                    <th colspan="3" class="td-2 black-bg" style="width: 190px;">Periode (Bln-Thn)</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 150px;">Jabatan/ Posisi</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 50px;">Grade</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 100px;">Status</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 100px;">Divisi</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 150px;">Keterangan</th>
                </tr>
                <tr>
                    <th class="td-2 black-bg">Awal</th>
                    <th class="td-2 black-bg">Akhir</th>
                    <th class="td-2 black-bg">Lamanya</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($career as $item)
                    <tr>
                        <td class="td-2">{{ \Carbon\Carbon::parse($item->start)->format('M-Y') }}</td>
                    <td class="td-2">{{ \Carbon\Carbon::parse($item->end)->format('M-Y') }}</td>
                    <td class="td-2">{{ $item->duration }} Bulan</td>
                    <td class="td-2">{{ $item->position }}</td>
                    <td class="td-2">{{ $item->grade }}</td>
                    <td class="td-2">{{ $item->status }}</td>
                    <td class="td-2">{{ $item->division }}</td>
                    <td class="td-2">{{ $item->remark }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
