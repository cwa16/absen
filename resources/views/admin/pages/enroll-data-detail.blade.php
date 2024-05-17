@include('admin.includes.head')

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 3px;
        text-align: center;
        font-size: 12px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

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
                                <h6 class="text-white text-capitalize ps-3">Enroll Data - Staff, Monthly, Regular</h6>
                            </div>
                        </div>
                        <!-- end bootstrap model -->

                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn btn-success btn-sm" id="btn-excel">Excel</button>
                                    <table class="table-fit" id="myTablex">
                                        @php
                                            $no = 0;
                                            $no1 = 0;
                                            $no2 = 0;
                                            $no3 = 0;
                                            $no4 = 0;
                                            $no5 = 0;
                                        @endphp
                                        <tr>
                                            <th colspan="3" style="background-color: black; color: white;">Summary Karyawan Berdasarkan Posisi</th>
                                        </tr>
                                        <tr>
                                            <th style="background-color: black; color: white;">No.</th>
                                            <th style="background-color: black; color: white;">Posisi</th>
                                            <th style="background-color: black; color: white;">Jumlah</th>
                                        </tr>
                                        @foreach ($sts as $key => $item)
                                            <tr>
                                                <td>{{ ++$no }}</td>
                                                <td>{{ $key }}</td>
                                                <td class="posisi">{{ $item->count() }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th id="total_posisi">{{ $sts_sum }}</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="8" style="background-color: black; color: white;">Summary Karyawan Berdasarkan Dept.</th>
                                        </tr>
                                        <tr>
                                            <th style="background-color: black; color: white;">No.</th>
                                            <th style="background-color: black; color: white;">Dept.</th>
                                            @foreach ($status as $key => $item)
                                                <th style="background-color: black; color: white;">{{ $item }}</th>
                                            @endforeach
                                            <th style="background-color: black; color: white;">Jumlah</th>
                                        </tr>
                                        @foreach ($dept_users as $key => $item)
                                            <tr>
                                                <td>{{ ++$no2 }}</td>
                                                <td>{{ $key }}</td>
                                                @foreach ($status as $item2)
                                                    <td>{{ $item->where('status', $item2)->count() }}</td>
                                                @endforeach
                                                <td>{{ $item->count() }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Total</th>
                                            @foreach ($dept_sum as $item)
                                            <th>
                                                {{ $item->count() }}
                                            </th>
                                            @endforeach
                                            <th>{{ $sts_sum }}</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6" style="background-color: black; color: white;">Summary Karyawan Berdasarkan Jenis Kelamin</th>
                                        </tr>
                                        <tr>
                                            <th style="background-color: black; color: white;">No.</th>
                                            <th style="background-color: black; color: white;">Dept.</th>
                                            @foreach ($sex as $item)
                                                <th style="background-color: black; color: white;">{{ $item }}</th>
                                            @endforeach
                                            <th style="background-color: black; color: white;">Jumlah</th>
                                        </tr>
                                        @foreach ($sex_users as $key => $item)
                                            <tr>
                                                <td>{{ ++$no3 }}</td>
                                                <td>{{ $key }}</td>
                                                @foreach ($sex as $item2)
                                                    <td>{{ $item->where('sex', $item2)->count() }}</td>
                                                @endforeach
                                                <td>{{ $item->count() }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Total</th>
                                            @foreach ($sex_sum as $item)
                                            <th>{{ $item->count() }}</th>
                                            @endforeach
                                            <th>{{ $sts_sum }}</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="8" style="background-color: black; color: white;">Summmary Karyawan Berdasarkan Agama</th>
                                        </tr>
                                        <tr>
                                            <th style="background-color: black; color: white;">No.</th>
                                            <th style="background-color: black; color: white;">Dept.</th>
                                            @foreach ($agama as $item)
                                                <th style="background-color: black; color: white;">{{ $item }}</th>
                                            @endforeach
                                            <th style="background-color: black; color: white;">Jumlah</th>
                                        </tr>
                                        @foreach ($agama_users as $key => $item)
                                            <tr>
                                                <td>{{ ++$no1 }}</td>
                                                <td>{{ $key }}</td>
                                                @foreach ($agama as $item1)
                                                    <td>{{ $item->where('agama', $item1)->count() }}</td>
                                                @endforeach
                                                <td>{{ $item->count() }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="3">Total</th>
                                            @foreach ($agama_sum as $item)
                                                <th>{{ $item->count() }}</th>
                                            @endforeach
                                            <th>{{ $sts_sum }}</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="10" style="background-color: black; color: white;">Summary Karyawan Berdasarkan Suku</th>
                                        </tr>
                                        <tr>
                                            <th style="background-color: black; color: white;">No.</th>
                                            <th style="background-color: black; color: white;">Dept.</th>
                                            @foreach ($suku as $item)
                                                <th style="background-color: black; color: white;">{{ $item }}</th>
                                            @endforeach
                                            <th style="background-color: black; color: white;">Jumlah</th>
                                        </tr>
                                        @foreach ($suku_users as $key => $item)
                                            <tr>
                                                <td>{{ ++$no4 }}</td>
                                                <td>{{ $key }}</td>
                                                @foreach ($suku as $item2)
                                                    <td>{{ $item->where('suku', $item2)->count() }}</td>
                                                @endforeach
                                                <td>{{ $item->count() }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Total</th>
                                            @foreach ($suku_sum as $item)
                                            <th>{{ $item->count() }}</th>
                                            @endforeach
                                            <th>{{ $sts_sum }}</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" style="background-color: black; color: white;">Summary Karyawan Berdasarkan Gol. Darah</th>
                                        </tr>
                                        <tr>
                                            <th style="background-color: black; color: white;">No.</th>
                                            <th style="background-color: black; color: white;">Dept.</th>
                                            @foreach ($gol_darah as $item)
                                                <th style="background-color: black; color: white;">{{ $item }}</th>
                                            @endforeach
                                            <th style="background-color: black; color: white;">Jumlah</th>
                                        </tr>
                                        @foreach ($gol_darah_users as $key => $item)
                                            <tr>
                                                <td>{{ ++$no5 }}</td>
                                                <td>{{ $key }}</td>
                                                @foreach ($gol_darah as $item2)
                                                    <td>{{ $item->where('gol_darah', $item2)->count() }}</td>
                                                @endforeach
                                                <td>{{ $item->count() }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th>Total</th>
                                        </tr>
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
    <script src="{{ 'js/tableToExcel.js' }}"></script>
    <script>
        $("#btn-excel").click(function() {
            TableToExcel.convert(document.getElementById("myTablex"), {
                name: "Enroll Data.xlsx",
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotals();

            function calculateTotals() {
                var posisiTotal = 0;

                // Loop through each row in the tbody
                document.querySelectorAll('tbody tr').forEach(function(row) {
                    var posisi = parseFloat(row.querySelector('.posisi').textContent);

                    posisiTotal += posisi;
                });

                // Update the totals in the footer
                document.getElementById('total_posisi').textContent = posisiTotal;
            }
        });
    </script>

</body>
