@include('admin.includes.head')

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
                                <h6 class="text-white text-capitalize ps-3">Summary Kehadiran Per Kategori</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row">
                                <div class="col">
                                    <div class="card mx-2">
                                        <div class="card-body">
                                            <form class="input-group" action="{{ route('load-summary-kategori') }}"
                                                method="post">
                                                @csrf
                                                <input type="month" name="date" id="" class="form-control"
                                                    required>
                                                <select name="group" id="" class="form-control" required>
                                                    <option value="" selected disabled>-- Pilih Group --</option>
                                                    <option value="All">All</option>
                                                    @foreach ($dept as $item)
                                                        <option value="{{ $item->dept }}">{{ $item->dept }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-primary mt-2">Load</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($data != null)
                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="card mx-2">
                                            <div class="card-body">
                                                <canvas id="myChart" width="700" height="200"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="card mx-2">
                                            <div class="card-body">
                                                <table
                                                    class="table table-bordered table-striped table-responsive table-hover"
                                                    id="table-data">
                                                    <thead>
                                                        <tr class="align-middle text-center">
                                                            <th rowspan="2">No</th>
                                                            <th rowspan="2">NIK</th>
                                                            <th rowspan="2">Employee Name</th>
                                                            <th colspan="11">Kehadiran Bulan {{ $months }}
                                                                {{ $year }}</th>
                                                            <th rowspan="2">Departement</th>
                                                        </tr>
                                                        <tr class="align-middle">
                                                            <th>H</th>
                                                            <th>M</th>
                                                            <th>MX</th>
                                                            <th>L</th>
                                                            <th>D</th>
                                                            <th>E</th>
                                                            <th>I</th>
                                                            <th>S</th>
                                                            <th>C</th>
                                                            <th>IX</th>
                                                            <th>SX</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $itemx => $item_list)
                                                            <tr>
                                                                <th colspan="15"
                                                                    style="background-color: rgb(255, 200, 0)">
                                                                    {{ $itemx }}</th>
                                                            </tr>
                                                            @foreach ($item_list as $key => $item)
                                                                <tr>
                                                                    <td>{{ ++$key }}</td>
                                                                    <td>{{ $item->nik }}</td>
                                                                    <td>{{ $item->name }}</td>
                                                                    @if ($item->desc == 'H')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'M')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'MX')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'L')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'D')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'E')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'I')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'S')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'CB' || $item->desc == 'CT' || $item->desc == 'CH' || $item->desc == 'CS' || $item->desc == 'CLL')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'IX')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    @if ($item->desc == 'SX')
                                                                        <td>{{ $item->total }}</td>
                                                                    @else
                                                                        <td>0</td>
                                                                    @endif

                                                                    <td>{{ $item->dept }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
    <script src="{{ 'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0' }}"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            plugins: [ChartDataLabels],
            type: 'bar',
            data: {
                labels: <?php echo $desc; ?>,
                datasets: [{
                    label: 'Total',
                    data: <?php echo $total; ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: Math.round,
                        font: {
                            weight: 'bold'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Grafik Kehadiran {{ $months }} {{ $year }}'
                    }
                }
            }
        });
    </script>
</body>
