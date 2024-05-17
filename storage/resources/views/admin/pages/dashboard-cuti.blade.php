@include('admin.includes.head')

<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
        <div class="container-fluid py-4">

            <div class="row mt-4">

                <div class="col-lg mt-4">
                    <div class="card z-index-2">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent"
                            style="background-color: white !important;">
                            <div class="bg shadow border-radius-lg py-3 pe-1">
                                <div class="card-body">
                                    <table
                                        class="table table-bordered table-responsive table-hover table-striped table-sm"
                                        id="myTable">
                                        <div class="row">
                                            <form action="{{ route('find-cuti') }}" method="post">
                                                @csrf
                                                <div class="col">
                                                    <input type="text" class="form-control" name="name"
                                                        id="" placeholder="Cari karyawan...">
                                                </div>
                                                <div class="col">
                                                    <select name="dept" id="" class="form-control">
                                                        <option value="" selected disabled>-- Pilih Sub Divisi --
                                                        </option>
                                                        @foreach ($dept as $item)
                                                            <option value="{{ $item->dept }}">{{ $item->dept }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <button class="btn btn-primary">Find</button>
                                                </div>
                                            </form>
                                        </div>
                                        <thead>
                                            <tr>
                                                <th colspan="10" class="text-center">Todate Cuti Karyawan BSKP
                                                    {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('Y') }}</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2" class="align-middle">NIK</th>
                                                <th rowspan="2" class="align-middle">Nama</th>
                                                <th rowspan="2" class="align-middle">Posisi</th>
                                                <th rowspan="2" class="align-middle">Sub Divisi</th>
                                                @if ($dept != 'I/A')
                                                    <th rowspan="2" class="align-middle">Kemandoran</th>
                                                @endif
                                                <th colspan="5" class="text-center">Jenis Cuti</th>
                                            </tr>
                                            <tr>
                                                <th colspan="1" class="align-middle">Besar</th>
                                                <th colspan="1" class="align-middle">Tahunan</th>
                                                <th colspan="1" class="align-middle">Melahirkan</th>
                                                <th colspan="1" class="align-middle">Sakit</th>
                                                <th colspan="1" class="align-middle">Lain-lain</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($dept != 'I/A')
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $item->nik }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->jabatan }}</td>
                                                        <td>{{ $item->dept }}</td>
                                                        @if ($item->mandor->isEmpty())
                                                            <td>-</td>
                                                        @else
                                                            @foreach ($item->mandor as $itemx)
                                                                <td>{{ $itemx->user->name }}</td>
                                                            @endforeach
                                                        @endif
                                                        <td>{{ $item->absen_reg->where('desc', 'CB')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'CT')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'CH')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'CS')->count() }}</td>
                                                        <td>{{ $item->absen_reg->where('desc', 'CLL')->count() }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                @foreach ($data as $item)
                                                    @foreach ($item->mandor as $itemx)
                                                        @foreach ($item->leave_budget as $itemb)
                                                            @foreach ($item->leave as $itemz)
                                                                <tr>
                                                                    <td>{{ $item->nik }}</td>
                                                                    <td>{{ $item->name }}</td>
                                                                    <td>{{ $item->jabatan }}</td>
                                                                    <td>{{ $item->dept }}</td>
                                                                    <td>{{ $itemx->user->name }}</td>
                                                                    <td>{{ $item->absen_reg->where('desc', 'CB')->count() }}
                                                                    </td>
                                                                    <td>{{ $item->absen_reg->where('desc', 'CT')->count() }}
                                                                    </td>
                                                                    <td>{{ $item->absen_reg->where('desc', 'CH')->count() }}
                                                                    </td>
                                                                    <td>{{ $item->absen_reg->where('desc', 'CS')->count() }}
                                                                    </td>
                                                                    <td>{{ $item->absen_reg->where('desc', 'CLL')->count() }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                    {{-- {{ $data->withQueryString()->links() }} --}}
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

    <style>
        #ww {
            color: rgba(255, 0, 0, 0.367);
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>
