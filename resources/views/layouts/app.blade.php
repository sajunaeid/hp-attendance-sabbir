<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('adminto/images/favicon.ico')}}">
        <!-- App css -->
        <link href="{{asset('adminto/css/app.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Icons css -->
        <link href="{{asset('adminto/css/icons.min.css')}}" rel="stylesheet" type="text/css">




        <!-- Header style -->
        @if (isset($headerstyle))
            {{ $headerstyle }}
        @endif


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        <!-- Theme Config Js -->
        <script src="{{asset('adminto/js/config.js')}}"></script>

        <script>
            let BASE_URL = {!! json_encode(url('/')) !!} + "/";
        </script>
    </head>
    <body class="font-space antialiased">

        <div class="flex wrapper">

            <!-- Menu -->
            @include('layouts.adminmenu')
            <!-- Sidenav Menu End  -->


            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="page-content">


                <!-- Topbar Start -->
                @include('layouts.adminheader')
                <!-- Topbar End -->

                <main class="p-6 relative">

                    {{-- for php flash --}}
                    <x-auth-session-status :status="Session::get('message')" id="notificationflush" onclick="hideflash()"></x-auth-session-status>
                    {{-- for ajax flash --}}
                    <div class="bg-seagreen/40 backdrop-blur-sm px-4 py-2 font-medium text-sm text-white absolute top-4 right-6 z-[11111] hover:bg-seagreen hidden" id="ajaxflash">
                        <div class="flex gap-4">
                            <p></p>
                            <span class="menu-icon"><i class="mdi mdi-close"></i></span>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="bg-seagreen/40 backdrop-blur-sm px-4 py-2 font-medium text-sm text-white absolute top-4 right-6 z-[11111] hover:bg-seagreen" id="sessionerror">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-white">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Page content -->
                    {{ $slot }}



                </main>

                <!-- Footer Start -->
                @include('layouts.adminfooter')
                <!-- Footer End -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>


        <!-- Plugin Js -->
        <script src="{{asset('adminto/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('adminto/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('adminto/libs/lucide/umd/lucide.min.js')}}"></script>
        <script src="{{asset('adminto/libs/%40frostui/tailwindcss/frostui.js')}}"></script>

        <!-- App Js -->
        <script src="{{asset('adminto/js/app.js')}}"></script>

        <!-- knob plugin -->
        <script src="{{asset('adminto/libs/jquery-knob/jquery.knob.min.js')}}"></script>

        <!--Morris Chart-->
        <script src="{{asset('adminto/libs/morris.js06/morris.min.js')}}"></script>
        <script src="{{asset('adminto/libs/raphael/raphael.min.js')}}"></script>

        <!-- Dashboard App js -->
        <script src="{{asset('adminto/js/pages/dashboard.init.js')}}"></script>

        {{-- Sweet alert --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- Custom main js --}}
        <script src="{{asset('js/main.js')}}"></script>


        <script>
            //------------------------
            $(document).ready(function () {
                // Ajax csrf token
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

        </script>


        <!--Footer script-->
        @if (isset($script))
        {{ $script }}
        @endif
    </body>
</html>
