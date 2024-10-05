<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Employees Woorking days (It's {{date('l')}} today)</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">
                @php
                    $currentDay = date('l');
                @endphp
                <table id="userTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                            <td>{{$employee->name}}</td>
                            @php
                                $weekends = json_decode($employee->we) ?? [];
                            @endphp
                            <td class="p-1 text-center {{ in_array('Saturday', $weekends) ? 'bg-red-400' : 'bg-green-400' }} @if($currentDay == 'Saturday') border-dashed border-2 border-sky-500  @endif">Saturday</td>
                            <td class="p-1 text-center {{ in_array('Sunday', $weekends) ? 'bg-red-400' : 'bg-green-400' }} @if($currentDay == 'Sunday') border-dashed border-2 border-sky-500  @endif">Sunday</td>
                            <td class="p-1 text-center {{ in_array('Monday', $weekends) ? 'bg-red-400' : 'bg-green-400' }} @if($currentDay == 'Monday') border-dashed border-2 border-sky-500  @endif">Monday</td>
                            <td class="p-1 text-center {{ in_array('Tuesday', $weekends) ? 'bg-red-400' : 'bg-green-400' }} @if($currentDay == 'Tuesday') border-dashed border-2 border-sky-500  @endif">Tuesday</td>
                            <td class="p-1 text-center {{ in_array('Wednesday', $weekends) ? 'bg-red-400' : 'bg-green-400' }} @if($currentDay == 'Wednesday') border-dashed border-2 border-sky-500  @endif">Wednesday</td>
                            <td class="p-1 text-center {{ in_array('Thursday', $weekends) ? 'bg-red-400' : 'bg-green-400' }} @if($currentDay == 'Thursday') border-dashed border-2 border-sky-500  @endif">Thursday</td>
                            <td class="p-1 text-center {{ in_array('Friday', $weekends) ? 'bg-red-400' : 'bg-green-400' }} @if($currentDay == 'Friday') border-dashed border-2 border-sky-500  @endif">Friday</td>
                        </tr>
                        @endforeach
                    </tbody>
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

        </script>
    </x-slot>
</x-app-layout>
