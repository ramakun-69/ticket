<link rel="shortcut icon" href="{{ URL::asset('images/logo.png') }}">
<!-- Layout config Js -->
<script src="{{ URL::asset('js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ URL::asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Sweet Alert-->
<link href="{{ URL::asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- IziToast-->
<link href="{{ URL::asset('libs/iziToast/iziToast.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<!-- Jquery Confirm-->
<link href="{{ asset('libs/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet" />
<!-- Datepicker -->
<link href="{{ asset('libs/flatpickr/dist/flatpickr.min.css') }}" rel="stylesheet">
<!-- Select2 -->
<link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
<!-- Custom CSS-->
<link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
<!-- App Css-->
<link href="{{ URL::asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
@if (isset($dt))
<style>
    .active>.page-link {
    background-color: #e33232;
    border-color: #e33232;
    }
</style>
<link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
type="text/css" />
<link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
type="text/css" />
<link href="{{ asset('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
type="text/css" />
<link href="{{ asset('libs/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet"
type="text/css" />
@endif
{{-- @vite('resources/css/app.css') --}}