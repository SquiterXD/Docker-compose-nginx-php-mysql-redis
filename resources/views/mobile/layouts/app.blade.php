<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOAT - @yield('title') </title>

    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{!! asset('mobile/css/app.css') !!}" />
    <link rel="stylesheet" href="{!! asset('mobile/css/vendor.css') !!}" />

</head>
<body style="background-color: #f3f3f4;">
    <div id="app-mobile">
       <div class="container">
           <div class="row">
               <div class="col-12 col-lg-6 offset-lg-3 p-0">
                    @include('mobile.layouts._side_menu')
               </div>
           </div>
          {{--  @if (env('FOR_TEST', false))
               <div class="row">
                    <div class="col-12 col-lg-6 offset-lg-3 p-0">
                        <div class="tw-border-solid tw-border-4 tw-border-gray-400 p-3 bg-danger">
                            <h4 class="no-margins text-center" style="color: #fff;">*** สำหรับทดสอบระบบเท่านั้น ***</h4>
                        </div>
                    </div>
                </div>
           @endif --}}
            <div class="row">
                <div class="col-12 col-lg-6 offset-lg-3 p-0">
                    <div class="tw-border-solid tw-border-4 tw-border-gray-400 p-3">
                        @include('shared._success_message')
                        @include('shared._error_message')

                        @yield('content')
                    </div>
                </div>
            </div>
       </div>
    </div>

    <script src="{!! asset('mobile/js/app.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('mobile/js/manifest.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('mobile/js/vendor.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('mobile/js/vendor/app.js') !!}" type="text/javascript"></script>

    {{-- <script src="{!! asset('js/manifest.js') !!}" type="text/javascript"></script> --}}
    {{-- <script src="{!! asset('js/vendor.js') !!}" type="text/javascript"></script> --}}

    @yield('mobile-footer-js')
    @section('mobile-scripts')
    @show
</body>
</html>