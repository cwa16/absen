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
                                <h6 class="text-white text-capitalize ps-3">Shift Detail</h6>
                            </div>
                        </div>

                        <div class="card mx-3 my-3">
                            <div class="card-body">
                                <div class="col">
                                    <form method="POST" action="{{ route('updateTaDesc') }}">
                                            @csrf
                                            @method('PUT')

                                        <button class="btn btn-primary btn-sm" type="submit">Simpan Perubahan</button>

                                        <table class="table table-bordered" id="detail-shift-emp">
                                            <thead class="bg-dark text-light">
                                                <tr>
                                                    <th></th>
                                                    <th>No</th>
                                                    <th>Tanggal Absen</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Keluar</th>
                                                    <th>Desc</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no=1;
                                                @endphp
                                                @forelse ($data as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="selected_ids[]" value="{{ $item->idAbsen }}">
                                                        </td>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{$item->date }}</td>
                                                        @if ($item->start_work == null)
                                                            <td><input type="time" class="form-control" id="start_work" name="start_work"></td>
                                                        @else
                                                            {{-- @php
                                                                $startWorkDateTime = Carbon\Carbon::parse($item->date . ' ' . $item->start_work);
                                                                $startWorkTime = $startWorkDateTime->format('H:i');
                                                            @endphp --}}
                                                            <td><input type="time" class="form-control" name="start_work" id="start_work" value="{{ \Carbon\Carbon::parse($item->start_work)->format('H:i:s') }}"></td>
                                                        @endif
                                                        @if ($item->end_work == null)
                                                            <td><input type="time" class="form-control" id="end_work" name="end_work"></td>
                                                        @else
                                                            {{-- @php
                                                                $endWorkDateTime = Carbon\Carbon::parse($item->date . ' ' . $item->end_work);
                                                                $endWorkTime = $endWorkDateTime->format('H:i');
                                                            @endphp --}}
                                                            <td><input type="time" class="form-control" name="end_work" id="end_work" value="{{ \Carbon\Carbon::parse($item->end_work)->format('H:i:s') }}"></td>
                                                        @endif
                                                        <td><input type="hidden" class="form-control" name="desc" id="desc" value="H">TA</td>
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
