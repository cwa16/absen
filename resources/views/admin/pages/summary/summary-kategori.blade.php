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
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive p-0">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%"
                                            style="float: right">
                                        <br>
                                        <form action="{{ route('summary-kategori-get') }}" method="POST">
                                            @csrf
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="">Kategori Kehadiran</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAllKategori" onclick="toggleAllKategori()">
                                                        <label class="form-check-label" for="selectAllKategori">
                                                            Select All Kategori
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="TA" value="TA" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Absen tidak lengkap (TA)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="D" value="D" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                Dinas (D)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="L" value="L" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Lambat (L)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="M" value="M" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                Mangkir (M)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="MX" value="MX" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Mangkir hari libur (MX)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="S" value="S" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                Sakit (S)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="SX" value="SX" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Sakit tidak dibayar (SX)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="I" value="I" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                Izin (I)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="IP" value="IP" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Izin Pribadi (IP)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="IX" value="IX" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                Izin tidak dibayar (IX)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="CT" value="CT" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                CT (Cuti Tahunan)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="CH" value="CH" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                CH (Cuti Melahirkan)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="CB" value="CB" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                CB (Cuti Besar)
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="CL" value="CL" name="kategori[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                CL (Cuti Lain-lain)
                                                            </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="">Status</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="status[]" id="selectAllStatus" onchange="selectAll()">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Select All Status
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="Manager" value="Manager" name="status[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Manager
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="Staff" value="Staff" name="status[]">
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                Staff
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="Monthly" value="Monthly" name="status[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Monthly
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="Regular" value="Regular" name="status[]">
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                Regular
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="Contract" value="Contract BSKP" name="status[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Contract BSKP
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="Contract" value="Contract FL" name="status[]">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Contract FL
                                                            </label>
                                                    </div>
                                                </div>
                                                @if ($userDept == 'HR Legal')
                                                    <div class="col">
                                                        <label for="">Filter Dept</label>
                                                        <select class="form-select mb-2" name="dept" id="dept">
                                                            <option selected disabled>Select Dept</option>
                                                            @foreach ($getEmployeesDept as $dept)
                                                                <option value="{{ $dept }}">{{ $dept }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="col">
                                                        <label for="">Filter Dept</label>
                                                        <select class="form-select mb-2" name="dept" id="dept">
                                                            <option value="{{ $userDept }}" selected>{{ $userDept }}</option>
                                                        </select>
                                                    </div>
                                                @endif

                                                <div class="col">
                                                    <label for="" class="form-label">Periode Awal</label>
                                                    <input type="date" name="start" id="" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label for="" class="form-label">Periode Akhir</label>
                                                    <input type="date" name="end" id="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                                                </div>
                                            </div>
                                        </form>
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
        function selectAll() {
            var checkboxes = document.querySelectorAll('input[name="status[]"]');
            var selectAllCheckbox = document.getElementById('selectAllStatus');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }
    </script>
    <script>
        function toggleAllKategori() {
            var selectAllCheckbox = document.getElementById('selectAllKategori');
            var checkboxes = document.querySelectorAll('input[name="kategori[]"]');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }
    </script>

</body>
