<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}" defer></script>
@if (Session::has('alert.config'))
    <script>
        Swal.fire({!! Session::pull('alert.config') !!});
    </script>
@endif
