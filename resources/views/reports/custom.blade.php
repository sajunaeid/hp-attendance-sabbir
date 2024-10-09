<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Custom Report</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">
                <form action="" method="get" id="customReport">
                    <div class="flex justify-start items-center gap-3">

                        <input type="date" name="startDate" id="startDate"
                            value="{{ $startOfThisWeek->format('Y-m-d') }}" class="dark:text-gray-950">
                        <input type="date" name="endDate" id="endDate"
                            value="{{ $endOfThisWeek->format('Y-m-d') }}" class="dark:text-gray-950">
                        <button type="submit"
                            class="font-mont px-10 py-3 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="p-6">
                <div class="">
                    <h2 class="font-bold text-xl font-space">This Week</h2>
                </div>
                <table id="thisweekreportTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Working Hour</th>
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
            var rangeFilter = null;
            $('form#customReport').submit(function(e) {
                e.preventDefault();
                rangeFilter.draw();
            });

            $(document).ready(function() {
                rangeFilter = $('#thisweekreportTable').DataTable({
                    dom: 'Bfrtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{!! route('reports.range') !!}",
                        data: function(d) {
                            d.startDate = $('#startDate').val();
                            d.endDate = $('#endDate').val();
                        },
                        beforeSend: function() {
                            // setting a timeout
                            // console.log($('#targatedDay').val());
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
                            render: function(data) {
                                return data.wh + ' hr';
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
                            data: 'total_wh_time',
                            name: 'total_wh_time'
                        }
                    ]
                });

            });
        </script>
    </x-slot>
</x-app-layout>
