<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Form Cuti</title>
    <style>
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
            background: rgb(0, 0, 0);
            color: white;
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
</head>

<body>
    <div class="container">
        <table class="table-1">
            <tr>
                <td style="width: 350px"><img src="{{ $image }}" alt="tt" width="250px"></td>
                <td style="width: 350px">
                    <div class="text-kanan"><b>PERMOHONAN PERSETUJUAN CUTI</b></div>
                </td>
            </tr>
            <tr>
                <td class="td-1">
                    <div class="text-kiri pt">PT. Bridgestone Kalimantan Plantation</div>
                </td>
                <td class="td-1">
                    <div class="text-kanan">(<i>Application Leave Approval</i>)</div>
                </td>
            </tr>
            <tr>
                <td class="td-1"></td>
                <td class="td-1">
                    <div class="text-kanan">APP NO : {{ $nomorForm }}</div>
                </td>
            </tr>
        </table>

        <table class="table-2" style="margin-top: 25px">
            <tr>
                <td class="td-2 black-bg" colspan="2">
                    <div class="text-kiri">1. INFORMASI KARYAWAN (<i>Employee Information</i>)</div>
                </td>
            </tr>
            <tr>
                <td class="td-2 box-small" style="width: 350px">
                    <div class="text-kiri">Nama (<i>Name</i>) : {{ $data->user->name }} </div>
                </td>
                <td class="td-2 box-small" style="width: 350px">
                    <div class="text-kiri">ID : {{ $data->user->nik }}</div>
                </td>
            </tr>
            <tr>
                <td class="td-2 box-small">Divisi (<i>Division</i>) : {{ $data->user->dept }}</td>
                <td class="td-2 box-small">
                    <div class="text-kiri">Jabatan (<i>Occupation</i>) : {{ $data->user->jabatan }}</div>
                </td>
            </tr>
            <tr>
                <td class="td-2 box-small">Status : {{ $data->user->status }}</td>
                <td class="td-2 box-small">Mulai Kerja (<i>Start Work</i>) : {{ $start_work }}</td>
            </tr>
        </table>

        <table class="table-3">
            <tr>
                <td class="td-2 black-bg" colspan="4">2. CUTI TERAKHIR (<i>Last Leave</i>)</td>
            </tr>
            <tr>
                <td class="td-2 box-small" style="width: 250px">Tanggal (<i>Date</i>) : {{($firstLeave != null) ? \Carbon\Carbon::parse($firstLeave->start_date)->format('d-m-Y') : "" }}</td>
                <td class="td-2 box-small text-tengah" style="width: 30px">To</td>
                <td class="td-2 box-small" style="width: 170px">{{ ($firstLeave != null) ? \Carbon\Carbon::parse($firstLeave->end_date)->format('d-m-Y') : "" }}</td>
                <td class="td-2 box-small" style="width: 245px">Total Hari (<i>Days Total</i>) : {{ ($firstLeave != null) ? $firstLeave->total : "" }}</td>
            </tr>
            <tr>
                <td class="td-2 box-small" colspan="4">Jenis Cuti (<i>Kind Of Leave</i>) : {{ ($firstLeave != null) ? $firstLeave->kind : "" }}</td>
            </tr>
        </table>

        <table class="table-3">
            <tr>
                <td class="td-2 black-bg" colspan="4">3. JADWAL CUTI (<i>Leave Schedule</i>)</td>
            </tr>
            <tr>
                <td class="td-2 box-small" style="width: 220px">Tanggal (<i>Date</i>) : {{ $fromC }}</td>
                <td class="text-tengah" style="width: 30px">To</td>
                <td class="td-2 box-small" style="width: 140px">{{ $toC }}</td>
                <td class="td-2 box-small" style="width: 305px">Total Hari (<i>Days Total</i>) : {{ $data->total }}</td>
            </tr>
            <tr>
                <td class="td-2 box-small" colspan="4">Kembali Bekerja (<i>Return Work</i>) : {{ \Carbon\Carbon::parse($data->return_date)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="td-2 box-small" colspan="4">Jenis Cuti (<i>Kind Of Leave</i>) : {{ $data->kind }}</td>
            </tr>
            <tr>
                <td class="td-2 box-small" colspan="4">Sisa Cuti (<i>Balance Of Leave</i>) : {{ $cuti_tahunan }}</td>
            </tr>
            <tr>
                <td class="td-2 box-small" colspan="4">Keterangan (<i>Remark</i>) : {{ $data->purpose }}</td>
            </tr>

        </table>

        <table class="table-3">
            <tr>
                <td class="td-2 box-small" colspan="4" style="width: 500px">
                    <div class="text-tengah"><b>Orang Yang Bertanggung Jawab Selama Cuti </b>(<i>Person In Charge During
                            Leave</i>)</div>
                </td>
            </tr>
            <tr>
                <td class="g-kiri td-2 box-small" style="width: 200px">Name (<i>Name</i>) : {{ $data->user_subs->name }}</td>
                <td style="width: 300px">ID : {{ $data->user_subs->nik }}</td>
                <td class="signature td-2 box-small" colspan="2" rowspan="2" style="width: 300px">Tanda Tangan (<i>Signature</i>) :
                </td>
            </tr>
            <tr>
                <td class="g-kiri td-2 box-small">Divisi (<i>Division</i>) : {{ $data->user_subs->dept }}</td>
                <td class="td-2 box-small" style="width: 200px">Jabatan (<i>Occupation</i>) : {{ $data->user_subs->jabatan }}</td>
            </tr>
        </table>

        <table class="table-5 td-2">
            <tr>
                <td class="td-2 black-bg" colspan="2">5. INFORMASI KONTAK SELAMA CUTI (<i>Contact Information During
                        Leave</i>)</td>
            </tr>
            <tr>
                <td class="td-2 box-small" style="width: 350px">Name (<i>Name</i>) : {{ $data->user->name }}</td>
                <td class="td-2 box-small" style="width: 350px">Nomor Telepon (<i>Phone Number</i>) : {{ $data->user->no_telpon }}</td>
            </tr>
        </table>

        <table class="table-5">
            <tr>
                <td class="text-tengah bold td-2" style="width: 100px">Pemohon</td>
                <td class="text-tengah bold td-2" style="width: 100px">Mandor</td>
                <td class="text-tengah bold td-2" style="width: 100px">Assistant</td>
                <td class="text-tengah bold td-2" style="width: 100px">Manager</td>
                <td class="text-tengah bold td-2" style="width: 100px">HR Manager</td>
                <td class="text-tengah bold td-2" style="width: 95px">Director</td>
                <td class="text-tengah bold td-2" style="width: 90px">President Director</td>
            </tr>
            <tr>
                <td class="box td-2"></td>
                <td class="box td-2"></td>
                <td class="box td-2"></td>
                <td class="box td-2"></td>
                <td class="box td-2"></td>
                <td class="box td-2"></td>
                <td class="box td-2"></td>
            </tr>
            <tr>
                <td class="td-2 text-tengah" style="word-wrap: break-word">{{ $data->user->name }}</td>
                <td class="td-2 text-tengah"></td>
                <td class="td-2 text-tengah" style="word-wrap: break-word"></td>
                <td class="td-2 text-tengah" style="word-wrap: break-word"></td>
                <td class="td-2 text-tengah" style="word-wrap: break-word">{{ $hr_manager }}</td>
                <td class="td-2 text-tengah" style="word-wrap: break-word">{{ $mfo }}</td>
                <td class="td-2 text-tengah" style="word-wrap: break-word">Tsunehisa Sakoda</td>
            </tr>
        </table>
    </div>
</body>

</html>
