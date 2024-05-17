@include('admin.includes.head')
<link href="{{ 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' }}" rel="stylesheet" />

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
                                <h6 class="text-white text-capitalize ps-3">Broadcast Attendance Mail</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div>
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%"
                                            style="float: right">
                                        <br>
                                        <form method="POST">
                                            @csrf
                                                <button formaction="{{ route('send-mail-batch') }}" type="submit" class="btn btn-warning mt-4">Send with Mail</button>
                                            <br>
                                            @if (isset($nik) && count($nik) > 0)
                                                <table
                                                    class="table table-striped table-bordered align-items-center mb-0"
                                                    id="table-shift" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-center">
                                                                <input type="checkbox" id="checkAll"></th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Emp Code</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Name</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Jabatan</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Dept</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Status</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                                                Detail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($nik as $data)
                                                            <tr>
                                                                <td class="text-center"><input type="checkbox" name="selected_ids[]" class="checkBoxClass" value="{{ $data->nik }}"></td>
                                                                <td>
                                                                    <input type="hidden" name="nik[]"
                                                                        value="{{ $data->nik }}">
                                                                    {{ $data->nik }}
                                                                </td>
                                                                <td>{{ $data->name }}</td>
                                                                <td>{{ $data->jabatan }}</td>
                                                                <td>{{ $data->dept }}</td>
                                                                <td>{{ $data->status }}</td>
                                                                <td class="text-center">
                                                                    <form method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="selected_emp_code[]" value="{{ $data->nik }}">
                                                                        <input type="hidden" name="from" value="{{ $firstDay }}">
                                                                        <input type="hidden" name="until" value="{{ $lastDay }}">
                                                                        <button formaction="{{ route('send-mail-preview') }}" type="submit" class="btn btn-danger btn-sm">Preview</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p>Tidak ada data yang cocok.</p>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.includes.footer')
    </main>
    @include('admin.includes.script')
    <script>
        document.getElementById("checkAll").addEventListener("change", function() {
            var checkboxes = document.getElementsByClassName("checkBoxClass");
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>
</body>
