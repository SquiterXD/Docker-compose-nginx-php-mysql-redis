<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>TOAT - @yield('title') </title> --}}
    <title>
        @if (session('db_name') != 'PROD')
            TOAT {{ session('db_name') }} - @yield('title')
        @else
            TOAT - @yield('title')
        @endif
    </title>

    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />

    <style type="text/css">
        [v-cloak] > * { display:none }
    </style> 
    @yield('custom_css')
    @show    

</head>
<body>
<div id="app">
  <!-- Wrapper-->
    <div id="wrapper">

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">


            <!-- Page wrapper -->
            @include('layouts.topnavbar')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    @yield('page-title')
                </div>
                <div class="col-lg-4 text-right pt-4">
                    @yield('page-title-action')
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                @include('shared._success_message')
                @include('shared._error_message')

                <!-- Main view  -->
                @yield('content')
            </div>


            <!-- Footer -->
            @include('layouts.footer')

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->
    <div class="bg-loader"></div>
    <div class="loader"></div>
</div>
<script src="{!! asset('js/vendor/app.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/jquery.datetimepicker.full.js') !!}"></script>
<script src="{!! asset('js/manifest.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/vendor.js') !!}" type="text/javascript"></script>
<script src="{!! mix('js/app.js') !!}" type="text/javascript"></script>
<!-- select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>

var body = $('body');
body.addClass('fixed-sidebar');
$('.sidebar-collapse').slimScroll({
    height: '100%',
    railOpacity: 0.9
});

$(function() {
    setNavigation();
    setNavigation();
});

async function setNavigation() {
    $("li.active").each( function(key2, value2) {
    let parentkey2 = $(value2).attr('parentkey');
    // console.log('=====', parentkey2)
    if (parentkey2 != undefined) {
            // console.log("1. ----------------", parentkey2)
            $(value2).addClass('active')
            $(value2).closest('ul').addClass('in')
            $("li.parentkey-"+parentkey2).each( function(key, value) {
            let parentkey = $(value).attr('parentkey');
                // console.log("2. ----------------", parentkey, value);
                $(value).addClass('active')
            });
        }
    });
}
</script>

@section('scripts')
@show

</body>
</html>
