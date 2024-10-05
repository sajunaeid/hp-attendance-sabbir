<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Weekly Report</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">
                <div class="">
                    <h2 class="font-bold text-xl font-space">This Week</h2>
                    <p>{{'( '.$startOfThisWeek->format('d-M-y').' to '.$endOfThisWeek->format('d-M-y').' )'}}</p>
                </div>
                <table id="thisweekreportTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Working Hour</th>
                            <th>Should worked</th>
                            <th>Worked</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="p-6">
                <div class="">
                    <h2 class="font-bold text-xl font-space">Last Week</h2>
                    <p>{{'( '.$startOfLastWeek->format('d-M-y').' to '.$endOfLastWeek->format('d-M-y').' )'}}</p>
                </div>
                <table id="lastweekreportTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Working Hour</th>
                            <th>Should worked</th>
                            <th>Worked</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


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
                var thisweek = $('#thisweekreportTable').DataTable({
                    dom: 'Bfrtip',
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: "{!! route('reports.thisWeek') !!}",
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
                            render: function(data) {
                                return data.wh+' hr';
                            }
                        },
                        {
                            data: null,
                            render: function (data) {
                                const weekendString = data.we;
                                const cleanedString = weekendString.replace(/[\[\]"]/g, '');
                                const weekendArray = cleanedString.split(',');
                                const numberOfElements = weekendArray.length;
                                return data.wh*numberOfElements+' hr';
                            }
                        },
                        {
                            data: 'total_wh_time',
                            name: 'total_wh_time'
                        }
                    ]
                });


                var lastweek = $('#lastweekreportTable').DataTable({
                    dom: 'Bfrtip',
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: "{!! route('reports.lastWeek') !!}",
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
                            data: 'wh',
                            name: 'wh'
                        },
                        {
                            data: null,
                            render: function (data) {
                                const weekendString = data.we;
                                const cleanedString = weekendString.replace(/[\[\]"]/g, '');
                                const weekendArray = cleanedString.split(',');
                                const numberOfElements = weekendArray.length;
                                return data.wh*numberOfElements+' hr';
                            }
                        },
                        {
                            data: 'total_wh_time',
                            name: 'total_wh_time'
                        }
                    ]
                });

            });

        </script>
    </x-slot>
</x-app-layout>


