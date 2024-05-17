<form class="form-inline" style="margin-bottom: -15px" action="{{ route('delete-cuti', $id) }}" method="post">
    @csrf
    <a href="{{ route('print', $id) }}" class="btn btn-warning btn-sm" target="_blank">PRINT</a>
    @if (Auth::user()->dept == 'HR Legal')
        <button class="btn btn-danger btn-sm">DELETE</button>
    @endif

</form>
