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
                                    <a href="{{ route('enroll-data-detail') }}" class="btn btn-primary btn-sm">Data
                                        Detail</a>
                                    <table class="table-fit" id="myTablex">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="background-color: black; color: white;" class="fit">No.</th>
                                                <th rowspan="2" style="background-color: black; color: white; width: 150px;" class="fit">Jabatan</th>
                                                <th colspan="{{ $dept->count() }}" style="background-color: black; color: white;" class="fit">Dept.</th>
                                                <th rowspan="2" style="background-color: black; color: white;" class="fit">Jlh</th>
                                            </tr>
                                            <tr>
                                                @foreach ($dept as $item)
                                                    <th class="fit" style="background-color: black; color: white; width: 150px;">{{ $item }}</th>
                                                @endforeach
                                            </tr>


                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach ($field as $key => $item)
                                                <tr>
                                                    <td style ="word-break:break-all;" class="fit">
                                                        {{ ++$no }}</td>
                                                    <td style ="width: 100px;" class="fit">
                                                        {{ $key }}</td>
                                                    @foreach ($item as $key1 => $itemx)
                                                        @if ($loop->first)
                                                            @foreach ($dept as $item2)
                                                                <td>{{ $item->where('dept', $item2)->count() }}</td>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    <td>{{ $item->count() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                @foreach ($field_sum as $item)
                                                    <th>{{ $item->count() }}</th>
                                                @endforeach
                                                <th>{{ $field_sum_all->count() }}</th>
                                            </tr>
                                        </tfoot>
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
                var quantityTotal = 0;
                var accTotal = 0;
                var purTotal = 0;
                var hrTotal = 0;
                var hrrTotal = 0;
                var hseTotal = 0;
                var itTotal = 0;
                var qaTotal = 0;
                var facTotal = 0;
                var fieldTotal = 0;
                var fsdTotal = 0;
                var gaTotal = 0;
                var aTotal = 0;
                var bTotal = 0;
                var cTotal = 0;
                var dTotal = 0;
                var eTotal = 0;
                var fTotal = 0;
                var qmTotal = 0;
                var secTotal = 0;
                var wsTotal = 0;
                var totTotal = 0;
                var priceTotal = 0;

                // Loop through each row in the tbody
                document.querySelectorAll('tbody tr').forEach(function(row) {
                    var quantity = parseFloat(row.querySelector('.bskp').textContent);
                    var acc = parseFloat(row.querySelector('.acc').textContent);
                    var pur = parseFloat(row.querySelector('.pur').textContent);
                    var hr = parseFloat(row.querySelector('.hr').textContent);
                    var hrr = parseFloat(row.querySelector('.hrr').textContent);
                    var hse = parseFloat(row.querySelector('.hse').textContent);
                    var it = parseFloat(row.querySelector('.it').textContent);
                    var qa = parseFloat(row.querySelector('.qa').textContent);
                    var fac = parseFloat(row.querySelector('.fac').textContent);
                    var field = parseFloat(row.querySelector('.field').textContent);
                    var fsd = parseFloat(row.querySelector('.fsd').textContent);
                    var ga = parseFloat(row.querySelector('.ga').textContent);
                    var a = parseFloat(row.querySelector('.a').textContent);
                    var b = parseFloat(row.querySelector('.b').textContent);
                    var c = parseFloat(row.querySelector('.c').textContent);
                    var d = parseFloat(row.querySelector('.d').textContent);
                    var e = parseFloat(row.querySelector('.e').textContent);
                    var f = parseFloat(row.querySelector('.f').textContent);
                    var qm = parseFloat(row.querySelector('.qm').textContent);
                    var sec = parseFloat(row.querySelector('.sec').textContent);
                    var ws = parseFloat(row.querySelector('.ws').textContent);
                    var tot = parseFloat(row.querySelector('.tot').textContent);

                    quantityTotal += quantity;
                    accTotal += acc;
                    purTotal += pur;
                    hrTotal += hr;
                    hrrTotal += hrr;
                    hseTotal += hse;
                    itTotal += it;
                    qaTotal += qa;
                    facTotal += fac;
                    fieldTotal += field;
                    fsdTotal += fsd;
                    gaTotal += ga;
                    aTotal += a;
                    bTotal += b;
                    cTotal += c;
                    dTotal += d;
                    eTotal += e;
                    fTotal += f;
                    qmTotal += qm;
                    secTotal += sec;
                    wsTotal += ws;
                    totTotal += tot;
                });

                // Update the totals in the footer
                document.getElementById('total_bskp').textContent = quantityTotal;
                document.getElementById('total_acc').textContent = accTotal;
                document.getElementById('total_pur').textContent = purTotal;
                document.getElementById('total_hr').textContent = hrTotal;
                document.getElementById('total_hrr').textContent = hrrTotal;
                document.getElementById('total_hse').textContent = hseTotal;
                document.getElementById('total_it').textContent = itTotal;
                document.getElementById('total_qa').textContent = qaTotal;
                document.getElementById('total_fac').textContent = facTotal;
                document.getElementById('total_field').textContent = fieldTotal;
                document.getElementById('total_fsd').textContent = fsdTotal;
                document.getElementById('total_ga').textContent = gaTotal;
                document.getElementById('total_a').textContent = aTotal;
                document.getElementById('total_b').textContent = bTotal;
                document.getElementById('total_c').textContent = cTotal;
                document.getElementById('total_d').textContent = dTotal;
                document.getElementById('total_e').textContent = eTotal;
                document.getElementById('total_f').textContent = fTotal;
                document.getElementById('total_qm').textContent = qmTotal;
                document.getElementById('total_sec').textContent = secTotal;
                document.getElementById('total_ws').textContent = wsTotal;
                document.getElementById('total_tot').textContent = totTotal;
            }
        });
    </script>

</body>
