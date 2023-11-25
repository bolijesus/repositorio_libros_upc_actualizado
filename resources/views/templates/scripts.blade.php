<!-- Jquery Core Js -->
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>


<!-- Slimscroll Plugin Js -->
<script src="{{ asset('js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('js/node-waves/waves.min.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('js/adminBSB/admin.js') }}"></script>

<!-- Demo Js -->
<script src="{{ asset('js/adminBSB/demo.js') }}"></script>
<!-- SweetAlert Plugin Js -->
<script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/pages/ui/dialogs.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@yield('scripts')


@if (session()->has('alert'))
<script>Swal.fire({{ session('alert') }} )</script>
@endif
    </body>
</html>