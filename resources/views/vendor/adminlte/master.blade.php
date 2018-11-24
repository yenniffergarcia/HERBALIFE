<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
    @yield('title', config('adminlte.title', 'IMEDCHI'))
    @yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/checkslider.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    <!-- Nuevo -->  
    <script src="{{ asset('js/herramientas/menuatras.js') }}"></script> 
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/herramientas/lscio.js') }}"></script> 
    <meta name="_token" content="{{ csrf_token() }}"/>

    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <script type="text/javascript" src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>        
        <link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>  
        <script src="http://malsup.github.io/jquery.blockUI.js"></script>

        <script src="{{ asset('js/highcharts.js') }}"></script>
        <script src="{{ asset('js/exporting.js') }}"></script>        

        <link href="{{ asset('bower_components/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet" />           
    @endif

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables with bootstrap 3 style -->   

        <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"> 
        <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;"> -->        
    @endif

    @yield('adminlte_css')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('maps')
    
</head>
<body class="hold-transition @yield('body_class')" onload="nobackbutton();" >

@yield('body')

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/jquery-knob/js/jquery.knob.js') }}"></script>

@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="{{ asset('js/select2.min.js') }}"></script>  
@endif

@if(config('adminlte.plugins.datatables'))
    <!-- DataTables with bootstrap 3 renderer -->
    <script src="{{ asset('js/datatables.min.js') }}"></script> 
    <!-- <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> -->
    <!-- Bootstrap JavaScript -->
    <!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->        
@endif

@if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
@endif

@yield('adminlte_js')

</body>
</html>
