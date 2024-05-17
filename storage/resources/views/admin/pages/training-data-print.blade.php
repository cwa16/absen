<!DOCTYPE html>
<html lang="en">
<style>
    html,
    body,
    table,
    button,
    a {
        font-family: 'Karla', sans-serif !important;
        font-size: 12px;
    }

    .container {
        size: a4;
    }


    table {
        border-collapse: collapse;
    }

    td,
    th,
    tr {
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

<div class="container">
    <div class="card">
        <div class="card-body">
            @foreach ($data as $item)
                <section class="kode" style="float: right;">
                    {{ $item->no }}
                </section>

                <section class="header-inhouse text-center" style="text-align: center; font-size: 16px;">
                    @if ($item->kind == 'internal')
                        <b>In-house Education/Training Record</b>
                    @else
                        <b>Ex-house Education/Training Record</b>
                    @endif
                </section>

                <table class="table-1" style="width: 100%; margin-top: 20px;">
                    <tr style="text-align: center;">
                        <th class="align-middle" rowspan="2">Trainer</th>
                        <th colspan="2">*Di evaluasi oleh</th>
                        <th colspan="4">*Di ketahui oleh</th>
                        <th>*Disimpan oleh</th>
                    </tr>
                    <tr>
                        <th>Trainer</th>
                        <th>Atasan</th>
                        <th>Asst. HRD</th>
                        <th>Asst. Mng</th>
                        <th>Div. Mng</th>
                        <th>Director</th>
                        <th>Adm. HRD</th>
                    </tr>
                    <tr>
                        <td style="height: 70px;"></td>
                        <td style="height: 70px;"></td>
                        <td style="height: 70px;"></td>
                        <td style="height: 70px;"></td>
                        <td style="height: 70px;"></td>
                        <td style="height: 70px;"></td>
                        <td style="height: 70px;"></td>
                        <td style="height: 70px;"></td>
                    </tr>
                </table>

                <table class="table-1" style="margin-top: 20px; width: 100%;">
                    <tr>
                        <td rowspan="2" colspan="3"><b>Judul Training :</b> {{ $item->topic }}</td>
                        <td><b>Tanggal Training</b></td>
                        <td colspan="2">{{ $item->from_date }} s/d {{ $item->to_date }}</td>
                    </tr>
                    <tr>
                        <td><b>Tempat</b></td>
                        <td colspan="2">{{ $item->place }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Nama Trainer : </b>{{ $item->user->name }}</td>
                        <td><b>Dept : {{ $item->user->dept }}</b></td>
                        <td colspan="2"><b>Posisi : {{ $item->user->jabatan }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <b>Summary Materi Training :</b>
                            <br>
                            <p>
                                @php
                                    echo nl2br($item->summary);
                                @endphp
                            </p>
                        </td>
                        <td colspan="3" style="vertical-align: top">
                            <b>Komentar Trainer :</b>
                            <br>
                            <p>
                                @php
                                    echo nl2br($item->comment)
                                @endphp
                            </p>
                        </td>
                    </tr>
                    <tr style="border-color: black; text-align:center;">
                        <td colspan="6" class="text-center" style="background-color: skyblue; border-color:black;">
                            <b>Penilaian Tingkat Pemahaman</b>
                        </td>
                    </tr>
                    <tr style="border-color: black; text-align:center;">
                        <td style="background-color: skyblue; border-color:black; width: 30px;">No</td>
                        <td style="background-color: skyblue; border-color:black; width: 70px;">NIK</td>
                        <td style="background-color: skyblue; border-color:black; width: 200px;">Nama</td>
                        <td style="background-color: skyblue; border-color:black;">Posisi</td>
                        <td style="background-color: skyblue; border-color:black;">Tingkat Pemahaman</td>
                        <td style="background-color: skyblue; border-color:black;">Komentar Atasan</td>
                    </tr>
                    @foreach ($item->attTrainings as $key => $itemx)
                        <tr style="text-align: center">
                            <td>{{ ++$key }}</td>
                            <td>{{ $itemx->nik }}</td>
                            <td>{{ $itemx->user->name }}</td>
                            <td>{{ $itemx->user->jabatan }}</td>
                            <td>{{ $itemx->score }} (1/2/3/4)</td>
                            <td>{{ $itemx->ket }} </td>
                        </tr>
                    @endforeach
                </table>
                <table class="table table-bordered" style="margin-top: 20px; width: 100%;">
                    <tr>
                        <td colspan="2"><b>Skor Tingkat Pemahaman Materi:</b></td>
                    </tr>
                    <tr>
                        <td>1. Tidak paham materi yang di ajarkan (< 50%)</td>
                        <td>2. Hanya paham sebagian materi yang diajarkan (50-69%)</td>
                    </tr>
                    <tr>
                        <td>3. Paham dengan materi yang di ajarkan (70-90%)</td>
                        <td>4. Paham hampir seluruh materi yang di ajarkan(> 90%)</td>
                    </tr>
                </table>
            @endforeach
        </div>
    </div>
</div>

<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            if ($PAGE_COUNT > 1) {
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $size = 10;
                $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
                $y = 810;
                $x = 280;
                $pdf->text($x, $y, $pageText, $font, $size);
            }
        ');
    }
    </script>

</html>
