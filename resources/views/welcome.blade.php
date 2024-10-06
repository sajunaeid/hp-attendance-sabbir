<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hahnemann Phamacy</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- Datatable css --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased relative">
    <div class="flex sm:justify-between items-center">
        <div class="flex justify-center items-center p-4">
            <img src="{{ asset('hp.svg') }}" alt="Hamneman Pharmacy" srcset="" class="h-10 sm:h-16">
            <h1 class="text-lg sm:text-2xl font-bold font-mont text-red-700 leading-5">Hahnemann <br> Pharmacy</h1>
        </div>
        <div class="">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <div class="flex gap-2">

                            <a href="{{ url('/dashboard') }}"
                                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="ml-5 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>

                        {{-- @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif --}}
                    @endauth
                </div>
            @endif
        </div>
    </div>
    {{-- Welcome div --}}
    <div class="">
        {{-- welcome div --}}
        <div class="px-6 flex justify-center items-center mx-auto max-w-2xl">
            <div class=" motion-safe:hover:scale-[1.01] transition-all duration-250">
                <div class="text-center">
                    <h2 class="text-5xl font-bold text-red-700 ">Welcome!</h2>
                    <p>Please Scan your ID Before entering or leaving</p>
                    <p class="text-red-700">You can only scan after 9 am and before 10pm</p>
                </div>
                <h2 class="my-24 text-2xl font-bold text-center absolute bg-teal-500/10 px-4 py-2 rounded-full top-8 right-6 hidden" id="message"></h2>
            </div>
        </div>
    </div>
    <div class="flex flex-col-reverse sm:flex-row mt-4">
        <div class="basis-1/2 px-6">
            <div class="card bg-gray-100 rounded-md ">
                <div class="p-6">
                    <h2 class="font-bold text-xl mb-6">Last Five Scan</h2>
                    <table id="reportTable" class="display stripe text-xs sm:text-base w-full" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Scan Type</th>
                                <th>Photo</th>
                                <th>Scan Time</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="basis-1/2 bg-dots-darker bg-center dark:bg-dots-lighter  selection:bg-red-500 selection:text-white ">
            <div class="card bg-gray-100 rounded-md px-6 lg:px-8">
                {{-- form and camera --}}
                <div class="p-6">
                    <div class="flex justify-center items-center mx-auto max-w-2xl px-6 pb-6">
                        <form action="{{ route('attendences.store') }}" method="post" id="idCardScanForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div id="my_camera"></div>
                                <div id="results"></div>
                            </div>
                            <br>
                            <label for="">Scan Your ID Card</label>
                            <input type="text" name="emp_number" id="emp_number_input" class="w-full mt-2" autofocus>
                            {{-- <input type="file" name="image" id="imageTag" class=" image-tag"> --}}
                            <input type="hidden" id="image-tag" name="image">
                            <div class="lg:col-span-2 mt-3 hidden">
                                <button type="submit"
                                    class="font-mont mt-8 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center py-4 px-0 items-center fixed bottom-0 w-full bg-white">
        <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
            <p>Developed by <a href="https://www.shadapixel.com/" target="_blank"
                    rel="noopener noreferrer hover:scale-1.1" class="text-seagreen font-space text-bold">Shada Pixel</a>
            </p>

        </div>
    </div>



    <!-- Plugin Js -->
    <script src="{{ asset('adminto/libs/jquery/jquery.min.js') }}"></script>
    <!-- Datatable script-->
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script>
        let BASE_URL = {!! json_encode(url('/')) !!} + "/";
        // Ajax csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var element = $('#scanNotification');





        $(document).ready(function() {
            var datatablelist = null;

            // Data table
            datatablelist = $('#reportTable').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                info: false,

                ajax: {
                    url: "{!! route('reports.latest') !!}",
                    data: function(d) {
                        d.targatedDay = $('#targatedDay').val();
                    },
                    beforeSend: function() {
                        // setting a timeout
                        console.log($('#targatedDay').val());
                    },
                },
                pageLength: 100,
                columns: [{
                        "render": function(data, type, full, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return data.employee.name;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            if (data.scan_type == 1) {
                                var statusLabels =
                                    '<span  class="text-green-500 text-sm px-2 inline-block">In</span>';
                            } else {
                                var statusLabels =
                                    '<span  class="text-red-500 text-sm px-2 inline-block">Out</span>';
                            }
                            // console.log(data);

                            return statusLabels;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            // var statusLabels = `<img  src="${BASE_URL}storage/66fffd4566ba3.png"/>`;

                            if (data.capture) {
                                var statusLabels =
                                    `<img  src="${BASE_URL}storage/capture${data.capture.image}" class="w-10"/>`;
                            } else {
                                var statusLabels =
                                    '<p class="text-red-500 text-sm px-2 inline-block">No Image</p>';
                            }

                            return statusLabels;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            let dateTimeString = data.scan_time;
                            let timeOnly = dateTimeString.split(' ')[1];
                            let [hours, minutes, seconds] = timeOnly.split(':');
                            let period = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12 || 12; // Convert '0' hours to '12' for 12 AM
                            let timeIn12HourFormat = `${hours}:${minutes} ${period}`;
                            return timeIn12HourFormat;
                        }
                    },
                ]
            });


            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });

            Webcam.attach('#my_camera', function(err) {
                if (err) {
                    console.error("Webcam not attached: ", err);
                } else {
                    console.log("Webcam attached successfully");
                }
            });


            function checkWebcam() {
                // Attempt to get user media (webcam access)
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        // If successful, attach the webcam
                        Webcam.set({
                            width: 320,
                            height: 240,
                            image_format: 'jpeg',
                            jpeg_quality: 90
                        });

                        Webcam.attach('#my_camera', function(err) {
                            if (err) {
                                console.error("Webcam not attached: ", err);
                            } else {
                                console.log("Webcam attached successfully");
                            }
                        });



                        // Stop the stream after attaching to prevent memory leak
                        stream.getTracks().forEach(track => track.stop());
                    })
                    .catch(function(error) {
                        console.error("Webcam access denied:", error);
                        alert("Please ensure your webcam is connected and permissions are granted.");
                    });
            }





            const idInput = $('#emp_number_input');

            idInput.change(function() {
                // Trigger form submission when the input value changes
                var inputValue = $(this).val();
                if (inputValue.length >= 9) {
                    console.log(inputValue);
                    $('form#idCardScanForm').submit();
                }
            });

            $('form#idCardScanForm').submit(function(event) {
                event.preventDefault(); // Prevent default

                // Check the webcam on page load
                // checkWebcam();
                // Configure the webcam

                Webcam.snap(function(data_uri) {
                    document.getElementById("image-tag").value = data_uri;
                    document.getElementById('results').innerHTML = '<img src="' + data_uri +
                        '"/>';
                });



                var form = $(this);
                var formData = new FormData(this);
                var submitButton = form.find(':submit');
                var messageElement = $('#message');

                submitButton.prop('disabled', true); // Disable submit button during AJAX request

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'), // Use form's action attribute
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success response
                        messageElement.removeClass('text-red-500 text-green-500').addClass(
                            response.mode == 1 ? 'text-green-500' : 'text-red-500').text(
                            response.message).fadeIn();

                        // Optionally, update datatable
                        datatablelist.draw();

                        form[0].reset(); // Reset form

                        setTimeout(function() {
                            messageElement.fadeOut().text('');
                        }, 5000);
                    },
                    error: function(xhr, status, error) {
                        // console.error(xhr.responseText);
                        messageElement.removeClass('text-red-500 text-green-500').addClass(
                            response.mode == 1 ? 'text-green-500' : 'text-red-500').text(
                            'Something went wrong. Please try again.').fadeIn();

                        form[0].reset(); // Reset form

                        setTimeout(function() {
                            messageElement.fadeOut();
                        }, 5000);
                    },
                    complete: function() {
                        submitButton.prop('disabled', false); // Re-enable submit button
                    }
                });
            });

        });
    </script>
</body>

</html>
