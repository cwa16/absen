@include('admin.includes.head')
<script>
    function updateChart() {
        location.reload();
    }

    setInterval(updateChart, 60000);
</script>
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
                                <h6 class="text-white text-capitalize ps-3">Dashboard Testing Absen</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">{!! $chart->container() !!}</div>
                            <br><br>
                            <div class="card">{!! $minutes->container() !!}</div>
                            <br><br>
                            <div class="card">{!! $daily->container() !!}</div>
                            <br><br>
                            <div class="card">{!! $weekly->container() !!}</div>
                            <br><br>
                            <div class="card">{!! $monthly->container() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </main>
    @include('admin.includes.script')

    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}

    <script src="{{ $minutes->cdn() }}"></script>
    {{ $minutes->script() }}

    <script src="{{ $daily->cdn() }}"></script>
    {{ $daily->script() }}

    <script src="{{ $weekly->cdn() }}"></script>
    {{ $weekly->script() }}

    <script src="{{ $monthly->cdn() }}"></script>
    {{ $monthly->script() }}

</body>
