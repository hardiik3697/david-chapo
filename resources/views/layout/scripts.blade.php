<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/js/dropdown-hover.js') }}"></script>
<script src="{{ asset('assets/vendor/js/mega-dropdown.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/nouislider/nouislider.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('assets/js/front-main.js') }}"></script>
<script src="{{ asset('assets/js/axios.min.js') }}"></script>

<script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}" type="text/javascript"></script>

<script> const APP_URL = "{{ __settings('SITE_FRONT_URL') }}"</script>

<script>
    toastr.options = {
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

@php
$success = '';
if (\Session::has('success'))
    $success = \Session::get('success');

$error = '';
if (\Session::has('error'))
    $error = \Session::get('error');
@endphp

<script>
    var success = "{{ $success }}";
    var error = "{{ $error }}";
    
    if (success != '') {
        toastr.success(success, 'Success');
    }
    
    if (error != '') {
        toastr.error(error, 'error');
    }
</script>

@yield('scripts')