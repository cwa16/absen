@include('admin.includes.head')

<body class="g-sidenav-show bg-gray-200">
    @include('sweetalert::alert')
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Set Jam Kerja
                            </div>
                        </div>
                        <div class="card mx-3 my-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <table class="table">
                                            <tr>
                                                <th>Dept</th>
                                                <th>Jabatan</th>
                                            </tr>
                                            <form action="{{ route('set-work-hour-store') }}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <tr>
                                                            <td>
                                                                <select class="form-control" name="dept"
                                                                    id="dept">
                                                                    <option value="" selected disabled>-- Select
                                                                        Dept --
                                                                    </option>
                                                                    @foreach ($dept as $item)
                                                                        <option value="{{ $item->dept }}">
                                                                            {{ $item->dept }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="position"
                                                                    id="position">
                                                                    <option value=""></option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="workhour" id=""
                                                                    class="form-control">
                                                                    <option value="" selected disabled>-- pilih
                                                                        jam kerja --</option>
                                                                    @foreach ($hour as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->name }}, Senin - Kamis :
                                                                            {{ $item->start_work_sk }} -
                                                                            {{ $item->end_work_sk }} | Jum'at : {{ $item->start_work_j }} - {{ $item->end_work_j }} | Sabtu : {{ $item->start_work_s }} - {{ $item->end_work_s }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-primary" name="action"
                                                                    value="check">Set</button>
                                                            </td>
                                                        </tr>
                                                    </div>
                                                </div>
                                            </form>
                                        </table>
                                    </div>
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
        $(document).ready(function() {
            $('#workTable').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });
        });
    </script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#dept').click(function() {
                $.ajax({
                    url: '{{ route('set-work-hour-select-dept') }}',
                    method: 'POST',
                    data: {
                        dept: $(this).val()
                    },
                    success: function(response) {
                        $('#position').empty();

                        $.each(response.jabatan, function(data, data) {
                            $('#position').append(new Option(data, data))
                        })
                    }
                });
            });

            $('.table-data').on('click', '.btn-add', function() {
                var $tr = $(this).closest('.tr-clone');
                var $clone = $tr.clone();
                $clone.find(':text').val('');
                $tr.after($clone);
            });
            $('.table-data').on('click', '.btn-remove', function() {
                var $tr = $(this).closest('.tr-clone');
                var $clone = $tr.clone();
                $clone.find(':text').val('');
                $tr.remove();
            });
        })
    </script>

</body>
