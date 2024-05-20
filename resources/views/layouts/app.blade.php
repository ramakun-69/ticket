@include('partials.header')
<body data-sidebar="colored">
    <!-- Begin page -->
    <div id="layout-wrapper">
            <!-- topbar -->
            @include('partials.navbar')
            <!-- sidebar components -->
            @include('partials.sidebar')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                @include('partials.footer')
                <!-- footer -->
            </div>
            <!-- end main content-->
    </div> 
    @include('partials.js')
</body>

</html>
