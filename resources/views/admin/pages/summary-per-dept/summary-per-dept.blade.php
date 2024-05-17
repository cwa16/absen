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
                                <h6 class="text-white text-capitalize ps-3">Kehadiran Karyawan Per Dept - Filter</h6>
                            </div>
                        </div>
                        <div class="card mx-3 my-3">
                            <div class="">
                                    <div class="">
                                        <div class="">
                                            <div class="card-header">
                                                <h3><strong>Kehadiran Karyawan Per Dept - Filter</strong></h3>
                                            </div>
                                            <form action="{{ route('summary-per-dept-filter-new') }}" method="post">
                                                @csrf
                                                <div class="card-body">
                                                    <table class="table table-bordered table-data" id="table-data">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size: 20px;">Dept</th>
                                                                <th style="font-size: 20px;">Tanggal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-select form-select-lg" aria-label="Default select example" id="select-data" name="dept">
                                                                        <option selected disabled>Pilih Departement</option>
                                                                        @if ($userDept == 'HR Legal' ||$userDept == 'BSKP')
                                                                            @foreach ($getEmployeesDept as $dept)
                                                                                <option value="{{ $dept }}">{{ $dept }}</option>
                                                                            @endforeach
                                                                        @else
                                                                            <option value="{{ $userDept }}" selecteds>{{ $userDept }}</option>
                                                                        @endif
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="date" name="datePick" class="form-control form-select-lg">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div id="data-container"></div>
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')
    {{-- <script>
        $(document).ready(function(){
            $('#select-data').change(function(){
                var selectedValue = $(this).val();
                $.ajax({
                    url: "{{ route('data-mandor') }}",
                    type: "GET",
                    data: { dept: selectedValue },
                    dataType: "json",
                    success: function(data){
                        console.log(data);
                        var content = '';
                        $.each(data, function(index, item){
                            content += '<p>' + item.name + '</p>';
                        });
                        $('#data-container').html(content);
                    }
                });
            });
        });
    </script> --}}
    <script>
        $(document).ready(function(){
            $('#data-container').on('change', '#checkboxAll', function(){
                $('.checkboxItem').prop('checked', $(this).prop('checked'));
            });

            $('#select-data').change(function(){
                var selectedValue = $(this).val();
                $.ajax({
                    url: "{{ route('data-mandor') }}",
                    type: "GET",
                    data: { dept: selectedValue },
                    dataType: "json",
                    success: function(data){
                        console.log(data);
                        var content = '<table class="table table-bordered table-data" style="width: 10%">';
                        if (data.length > 0) {
                            content += '<thead><tr><th><input type="checkbox" id="checkboxAll"></th><th>Mandor</th></tr></thead>';
                        }
                        content += '<tbody>';
                        $.each(data, function(index, item){
                            content += '<tr>';
                            content += '<td class="text-center"><input type="checkbox" class="checkboxItem" value="' + item.nik + '" name="mandor[]"></td>';
                            content += '<td><input type="hidden" value="' + item.nik + '">' + item.name + '</td>';
                            content += '</tr>';
                        });
                        content += '</tbody></table>';
                        $('#data-container').html(content);
                    }
                });
            });
        });
    </script>
</body>
