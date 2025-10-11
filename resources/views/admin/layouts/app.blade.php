<!DOCTYPE html>

<head>
    @include('admin.layouts.header')
</head>

<body class="body">

    <!-- #wrapper -->
    <div id="wrapper">
        <!-- #page -->
        <div id="page" class="">
            <!-- layout-wrap -->
            <div class="layout-wrap">
                <!-- preload -->
                <div id="preload" class="preload-container">
                    <div class="preloading">
                        <span></span>
                    </div>
                </div>
                <!-- /preload -->
                <!-- section-menu-left -->
                <div class="section-menu-left">
                    @include('admin.layouts.sidebar')
                </div>
                <!-- /section-menu-left -->
                <!-- section-content-right -->
                <div class="section-content-right">
                    <!-- header-dashboard -->
                    <div class="header-dashboard">
                        @include('admin.layouts.topbar')
                    </div>
                    <!-- /header-dashboard -->
                    <!-- main-content -->
                    <div class="main-content">
                        <!-- main-content-wrap -->
                        <div class="main-content-inner">
                            <!-- main-content-wrap -->
                            @yield('content')
                            <!-- /main-content-wrap -->
                        </div>
                        <!-- /main-content-wrap -->
                        <!-- bottom-page -->
                        <div class="bottom-page">
                            @include('admin.layouts.footer')
                        </div>
                        <!-- /bottom-page -->
                    </div>
                    <!-- /main-content -->
                </div>
                <!-- /section-content-right -->
            </div>
            <!-- /layout-wrap -->
        </div>
        <!-- /#page -->
    </div>
    <!-- /#wrapper -->

    <!-- Javascript -->
    <script src="{{ asset('backend/js/jquery.min.js')}}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('backend/js/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('backend/js/zoom.js')}}"></script>
    <script src="{{ asset('backend/js/apexcharts/apexcharts.js')}}"></script>
    <script src="{{ asset('backend/js/apexcharts/line-chart-1.js')}}"></script>
    <script src="{{ asset('backend/js/apexcharts/line-chart-2.js')}}"></script>
    <script src="{{ asset('backend/js/apexcharts/line-chart-3.js')}}"></script>
    <script src="{{ asset('backend/js/apexcharts/line-chart-4.js')}}"></script>
    <script src="{{ asset('backend/js/apexcharts/line-chart-5.js')}}"></script>
    <script src="{{ asset('backend/js/apexcharts/line-chart-6.js')}}"></script>
    <script src="{{ asset('backend/js/switcher.js')}}"></script>
    <script src="{{ asset('backend/js/theme-settings.js')}}"></script>
    <script src="{{ asset('backend/js/main.js')}}"></script>

</body>


</html>
