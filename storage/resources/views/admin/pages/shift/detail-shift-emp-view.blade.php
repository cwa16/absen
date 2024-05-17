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
                                <h6 class="text-white text-capitalize ps-3">Shift Detail - {{ $emp->name }}</h6>
                            </div>
                        </div>

                        <div class="card mx-3 my-3">
                            <div class="card-body">
                                <div class="col">
                                    <form method="POST" action="{{ route('updateShiftEmp') }}">
                                            @csrf
                                            @method('PUT')

                                        <button class="btn btn-primary btn-sm" type="submit">Simpan Perubahan</button>

                                        <table class="table table-bordered" id="detail-shift-emp">
                                            <thead class="bg-dark text-light">
                                                <tr>
                                                    <th></th>
                                                    <th>No</th>
                                                    <th>Tanggal Shift</th>
                                                    <th>Jam Kerja</th>
                                                    <th>Shift</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no=1;
                                                @endphp
                                                @forelse ($shiftArchiveDataEmp as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}">
                                                        </td>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d') }} - {{ \Carbon\Carbon::parse($item->end_date)->format('d M y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->start_work)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->end_work)->format('H:i') }}</td>
                                                        <td>
                                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="shift">
                                                                <option selected disabled>Pilih Shift</option>
                                                                @foreach ($masterShifts as $shift)
                                                                    @if ($item->shift == $shift->id)
                                                                        <option value="{{ $shift->id }}" selected>{{ $shift->shift }} | {{ $shift->start_work->format('H:i:s') }} | {{ $shift->end_work->format('H:i:s') }}</option>
                                                                    @else
                                                                        <option value="{{ $shift->id }}">{{ $shift->shift }} | {{ $shift->start_work->format('H:i:s') }} | {{ $shift->end_work->format('H:i:s') }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    {{-- <tr></tr> --}}
                                                @empty
                                                    <tr>
                                                        <td colspan="2">Belum ada data</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </form>
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

    <script>
        $('#detail-shift-emp').DataTable();
    </script>

</body>
