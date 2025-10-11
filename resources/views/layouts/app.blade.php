<!DOCTYPE html>

<head>
    @include('admin.layouts.header')
</head>

<body class="body">

    <!-- #wrapper -->
    <div id="wrapper">
        <!-- #page -->
        @yield('content')
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
