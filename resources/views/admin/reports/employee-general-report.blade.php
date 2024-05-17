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

    .table-container {
        display: inline-block;
        margin-top: 110px;
        font-size: 14px;
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
        background: orange;
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
            </tr>
            <tr>
                <td class="td-1">
                    <div class="text-kiri pt">PT. BRIDGESTONE KALIMANTAN PLANTATION</div>
                </td>
            </tr>
            <tr>
                <td class="td-1" style="font-size: 20px; width: 480px;"><b>HUMAN RESOURCE DEPARTEMENT</b></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td style="font-size: 20px;"><b><u>DATA DIRI</u></b></td>
                <td style="font-size: 20px;"><b><u>RIWAYAT PEKERJAAN</u></b></td>
            </tr>
        </table>

        <div class="table-container">
            <table class="table-1 td-2">
                <tr>
                    <td rowspan="22" class="td-2" style="width: 150px; text-align:center;">
                        <img src="{{ $image_profile }}" width="130px" style="margin-top: -150px;">
                    </td>
                    <td style="width: 150px;">
                        Employee Code
                    </td>
                    <td>
                        :
                    </td>
                    <td style="width: 150px;">
                        {{ $emp->nik }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Nama
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Jenis Kelamin
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->sex }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Tanggal Lahir
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($emp->ttl)->format('d-M-Y') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Pendidikan
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->pendidikan }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Start Kerja
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->start }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Jabatan
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->jabatan }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Golongan
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->status }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Agama
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->agama }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Suku
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->suku }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Nomor Telpon
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->no_telpon }}
                    </td>
                </tr>
                <tr>
                    <td>
                        NIK KTP
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->nik }}
                    </td>
                </tr>
                <tr>
                    <td>
                        No. KPJ
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->kpj }}
                    </td>
                </tr>
                <tr>
                    <td>
                        No. BPJS Kesehatan
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->kis }}
                    </td>
                </tr>
                <tr>
                    <td>
                        No. Rekening
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->no_bank }}
                    </td>
                </tr>
                <tr>
                    <td>
                        No. Sepatu Safety
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->no_sepatu_safety }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Ukuran Baju
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->no_baju }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Status Perkawinan
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->status_pernikahan }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Istri/Suami
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $emp->istri_suami }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Anak
                    </td>
                    <td>
                        1
                    </td>
                    <td>
                        {{ $emp->anak_1 }}
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>
                        2
                    </td>
                    <td>
                        {{ $emp->anak_2 }}
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>
                        3
                    </td>
                    <td>
                        {{ $emp->anak_3 }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="table-container" style="vertical-align:top; margin-top: 3px; margin-left: 10px;">
            <table class="table-1 td-2">
                <tr style="background-color: #d3d3d3">
                    <th class="td-2" style="width: 80px; height: 30px;">From Date</th>
                    <th class="td-2" style="width: 80px;">To Date</th>
                    <th class="td-2">Lamanya <br>(Thn)</th>
                    <th class="td-2">Posisi Jabatan</th>
                    <th class="td-2" style="width: 80px;">Status</th>
                    <th class="td-2" style="width: 80px;">Divisi</th>
                </tr>
                @foreach ($work as $item)
                    <tr style="text-align: center;">
                        <td class="td-2">{{ \Carbon\Carbon::parse($item->start)->format('M-Y') }}</td>
                        <td class="td-2">{{ \Carbon\Carbon::parse($item->end)->format('M-Y') }}</td>
                        <td class="td-2">{{ $item->duration }}</td>
                        <td class="td-2">{{ $item->position }}</td>
                        <td class="td-2">{{ $item->status }}</td>
                        <td class="td-2">{{ $item->division }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <table style="float: right;">
            <tr>
                <td class="td-2">Update Per : {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('M-y') }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
