<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Monthly Report</x-slot>


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
                    <select id="targatedMonth" name="targatedMonth" class="dark:text-gray-950">
                        <option value="01" @if($thisMonth == '01') selected @endif >January</option>
                        <option value="02" @if ($thisMonth == '02') selected @endif >February</option>
                        <option value="03" @if ($thisMonth == '03') selected @endif >March</option>
                        <option value="04" @if ($thisMonth == '04') selected @endif >April</option>
                        <option value="05" @if ($thisMonth == '05') selected @endif >May</option>
                        <option value="06" @if ($thisMonth == '06') selected @endif >June</option>
                        <option value="07" @if ($thisMonth == '07') selected @endif >July</option>
                        <option value="08" @if ($thisMonth == '08') selected @endif >August</option>
                        <option value="09" @if ($thisMonth == '09') selected @endif >September</option>
                        <option value="10" @if ($thisMonth == '10') selected @endif >October</option>
                        <option value="11" @if ($thisMonth == '11') selected @endif >November</option>
                        <option value="12" @if ($thisMonth == '12') selected @endif >December</option>
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

                $('#targatedMonth').on('change', function () {
                    datatablelist.draw();
                });



                datatablelist = $('#reportTable').DataTable({
                    dom: 'Bfrtip',
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: "{!! route('reports.monthly') !!}",
                        data: function (d) {
                            d.targatedMonth = $('#targatedMonth').val();
                        },
                        beforeSend: function() {
                            // setting a timeout
                            console.log($('#targatedMonth').val());
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


