@include('admin.includes.head')

<body class="g-sidenav-show bg-gray-200">
    @include('admin.layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('admin.layouts.navbar')
        <div class="container-fluid py-4">

            <div class="row">
                @foreach ($departments as $department)
                <div class="col-sm-6 mb-3 mb-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $department }}</h5>
                            <p class="card-text">last updated at ({{ $latest }})</p>
                            @if ($department == 'I/A')
                            <a href="{{ route('dash-a') }}" class="btn btn-primary">Detail</a>
                            @elseif ($department == 'I/B')
                            <a href="{{ route('dash-b') }}" class="btn btn-primary">Detail</a>
                            @elseif ($department == 'I/C')
                            <a href="{{ route('dash-c') }}" class="btn btn-primary">Detail</a>
                            @elseif ($department == 'II/D')
                            <a href="{{ route('dash-d') }}" class="btn btn-primary">Detail</a>
                            @elseif ($department == 'II/E')
                            <a href="{{ route('dash-e') }}" class="btn btn-primary">Detail</a>
                            @elseif ($department == 'II/F')
                            <a href="{{ route('dash-f') }}" class="btn btn-primary">Detail</a>
                            @elseif ($department == 'BSKP')
                            <a href="{{ route('dash-bskp') }}" class="btn btn-primary">Detail</a>
                            @elseif ($department == 'IT')
                            <a href="{{ route('dash-it') }}" class="btn btn-primary">Detail</a>
                            @elseif ($department == 'Factory')
                            <a href="{{ route('dash-factory') }}" class="btn btn-primary">Detail</a>
                            @else
                            <a href="{{ route('dash-accfin') }}" class="btn btn-primary">Detail</a>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-lg mt-4">

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

</body>
