<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2">
        <div class="flex flex-col gap-6 col-span-2 sm:col-span-1">

            <div class="">
                <div class="card">
                    <div class="p-6">
                        <form action="" method="get" id="dailyreport">
                            <input type="date" name="targatedDay" id="targatedDay" value="{{ $targatedDate }}" class="dark:text-gray-950">
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <table id="reportTable" class="display stripe text-xs sm:text-base" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>Presence</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div> <!-- flex-end -->
    </div>



    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> --}}
        <script>
            $(document).ready(function () {
                var datatablelist = null;

                $('#targatedDay').on('change', function () {
                    datatablelist.draw();
                });



                datatablelist = $('#reportTable').DataTable({
                    dom: 'Bfrtip',
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: "{!! route('reports.present') !!}",
                        data: function (d) {
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
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'emp_id',
                            name: 'emp_id'
                        },
                        {
                            data: null,
                            render: function (data) {
                                if (data.ads == 1 ){
                                    var statusLabels = '<span  class="text-green-500 text-sm px-2 inline-block">Present</span>';
                                }else {
                                    var statusLabels = '<span  class="text-red-500 text-sm px-2 inline-block">Absent</span>';
                                }
                                // console.log(data);

                                return statusLabels;
                            }
                        },
                        {
                            data: null,
                            render: function (data) {
                                if (data.state == 1 ){
                                    var statusLabels = '<span  class="text-green-500 text-sm px-2 inline-block">In</span>';
                                }else{
                                    var statusLabels = '<span  class="text-red-500 text-sm px-2 inline-block">Out</span>';
                                }
                                // console.log(data);

                                return statusLabels;
                            }
                        }
                    ]
                });

            });

        </script>
    </x-slot>
</x-app-layout>
