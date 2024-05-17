  <!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  {{-- <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script> --}}
  {{-- <script src="{{ 'https://code.jquery.com/jquery-3.5.1.js' }}"></script> --}}

<script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
<script src="{{ asset('js/stickycolumn.js') }}"></script>
<script src="{{ asset('js/BsMultiSelect.min.js') }}"></script>
{{-- <script src="{{ asset('js/multiselect-dropdown.js') }}"></script> --}}

<script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{asset('js/chart.min.js')}}" charset="utf-8"></script>
<script src="{{ 'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2 ' }}"></script>
<script src="{{ 'https://cdn.jsdelivr.net/npm/apexcharts' }}"></script>
<script src="{{'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'}}"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.0.2"></script>
