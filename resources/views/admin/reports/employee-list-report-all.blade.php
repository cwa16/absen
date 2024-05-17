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

    /* Define even and odd row colors */
    tr.even {
        background-color: #e1e1e1;
        /* Light gray */
    }

    tr.odd {
        background-color: #ffffff;
        /* White */
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
        background: rgb(177, 177, 176);
        color: balck;
        height: 10px;
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
                <td style="width: 330px">
                    <div class="text-kanan"><u><b>{{ $ket ? $ket : 'RESIGNED' }} EMPLOYEE LIST</b></u></div>
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
            <thead>
                <tr class="td-2">
                    <th rowspan="2" class="td-2 black-bg" style="width: 80px;">NIK</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 160px;">Employee Name</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 35px;">Sex</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 45px;">Grade</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 100px;">Departement</th>
                    <th colspan="2" class="td-2 black-bg">Years</th>
                    <th rowspan="2" class="td-2 black-bg" style="width: 150px;">Status</th>
                </tr>
                <tr>
                    <th class="td-2 black-bg" style="width: 45px;">Work</th>
                    <th class="td-2 black-bg" style="width: 45px;">Old</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resign as $key => $item)
                    <tr>
                        <td colspan="8"></td>
                    </tr>
                    <tr>
                        <td><b><u>{{ $key }}</u></b></td>
                    </tr>
                    {{-- Fetch and display individual employee details for the current department --}}
                    @foreach ($item as $key1 => $employee)
                        <tr class="{{ $key1 % 2 == 0 ? 'even' : 'odd' }}">
                            <td class="td-2">{{ $employee->nik }}</td>
                            <td class="td-2">{{ $employee->name }}</td>
                            <td class="td-2">{{ $employee->sex }}</td>
                            <td class="td-2">{{ $employee->grade }}</td>
                            <td class="td-2">{{ $employee->dept }}</td>
                            <td class="td-2">{{ number_format($employee->total_years, 1) }}</td>
                            <td class="td-2">{{ number_format($employee->old, 1) }}</td>
                            <td class="td-2">
                                @if ($employee->active == 'yes')
                                Aktif
                                @else
                                Nonaktif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="td-2"><b> {{ $item->count() }} Persons</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
