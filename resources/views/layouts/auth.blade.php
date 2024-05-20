<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('images/logo.png') }}">
    <!-- Layout config Js -->
    <script src="{{ URL::asset('js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ URL::asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ URL::asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('libs/iziToast/iziToast.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
    
    @yield('content')

   <!-- JAVASCRIPT -->
<script src="{{ URL::asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('libs/node-waves/waves.min.js') }}"></script>
<script src="{{ URL::asset('js/support/loading.js') }}"></script>
<script src="{{ URL::asset('libs/iziToast/iziToast.min.js') }}"></script>
<script src="{{ URL::asset('js/app.js') }}"></script>
<!-- Icon -->
<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
<script>
    $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
     });
 </script>
@stack('js')
</body>
</html>
