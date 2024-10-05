<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Yearly Report</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">
                <form action="" method="get" id="dailyreport">
                    <select name="targatedYear" id="targatedYear" class="dark:text-gray-950">
                        @php
                            $startYear = date('Y') - 1; // Adjust the range as needed
                            $endYear = date('Y') + 17;
                        @endphp

                        @for ($year = $startYear; $year <= $endYear; $year++)
                            <option value="{{ $year }}" @if($year == date('Y')) selected @endif>{{ $year }}</option>
                        @endfor
                    </select>
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
            $(document).ready(function () {
                var datatablelist = null;

                $('#targatedYear').on('change', function () {
                    datatablelist.draw();
                });



                datatablelist = $('#reportTable').DataTable({
                    dom: 'Bfrtip',
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: "{!! route('reports.yearly') !!}",
                        data: function (d) {
                            d.targatedYear = $('#targatedYear').val();
                        },
                        beforeSend: function() {
                            // setting a timeout
                            console.log($('#targatedYear').val());
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
                                return data.wh+' hr';
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


