<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter  selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                    <div class="flex gap-2">

                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="ml-5 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif --}}
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">

                    <h1 class="text-5xl font-bold font-mont text-seagreen">Haniman Phamacy</h1>
                </div>

                <div class="mt-16">
                    <div class="flex justify-center items-center mx-auto max-w-2xl bg-zinc-200 rounded-md">


                        <div class=" motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div class="my-10 text-center space-y-5">
                                <h2 class="text-5xl font-bold text-red-500 ">Welcome!</h2>
                                <p>Please Scane your ID Before entering or leaving</p>
                            </div>
                                <h2 class="my-10 text-xl font-bold text-red-500 text-center min-h-18" id="scanNotification">Scan Your ID Card</h2>
                                {{-- <h2 class="my-24 text-xl font-bold text-green-500  hidden">Office in</h2> --}}
                        </div>
                    </div>
                </div>


                <div class="mt-2 opacity-0">
                    <div class="flex justify-center items-center mx-auto max-w-2xl bg-zinc-200 rounded-md p-6">
                        <form action="{{route('attendences.store')}}" method="post" id="idCardScanForm">
                            @csrf
                            <input type="text" name="emp_number" id="emp_number_input" autofocus>
                            <div class="lg:col-span-2 mt-3">
                                <button type="submit"
                                    class="font-mont mt-8 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Save</button>
                            </div> <!-- end button -->
                        </form>
                    </div>
                </div>

                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
                        <div class="flex items-center gap-4">
                            <a href="javascript:void(0)" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="-mt-px mr-1 w-5 h-5 stroke-gray-400 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                With love
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        <p>Developed by <a href="https://www.shadapixel.com/" target="_blank" rel="noopener noreferrer hover:scale-1.1" class="text-seagreen font-space text-bold">Shada Pixel</a></p>

                    </div>
                </div>
            </div>
        </div>


        <!-- Plugin Js -->
        <script src="{{asset('adminto/libs/jquery/jquery.min.js')}}"></script>
        <script>
            // Ajax csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var element = $('#scanNotification');

            $(document).ready(function() {

                $('#emp_number_input').change(function() {
                    // Trigger form submission when the input value changes
                    $('form#idCardScanForm').submit();
                });

                $('#emp_number_input').on('input', function() {
                    // Trigger form submission when the input value changes
                    $('form#idCardScanForm').submit();
                });


                $('form#idCardScanForm').submit(function(event) {
                    event.preventDefault(); // Prevent default form submission

                    var formData = $(this).serialize(); // Serialize form data

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("attendences.store") }}', // Replace with your route name
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response.message); // Handle success response

                            element.text(response.message);
                            $('form#idCardScanForm')[0].reset();
                            // Change inner text to 'Scan your ID' after another 3 seconds
                            setTimeout(function() {
                                element.text('Scan Your ID Card');
                            }, 3000);
                        },
                        error: function(xhr, status, error) {
                            // console.error(error); // Handle error
                            element.text('Something Wrong');
                            $('form#idCardScanForm')[0].reset();
                            // Change inner text to 'Scan your ID' after another 3 seconds
                            setTimeout(function() {
                                element.text('Scan Your ID Card');
                            }, 3000);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
