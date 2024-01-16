<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$employee->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">

                    <div class="flex gap-4">
                        <a href="{{route('employees.edit',$employee->id)}}">
                            <button type="submit" class="font-mont px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Edit</button>
                        </a>
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <h1 class="text-2xl font-semibold mt-4 capitalize">{{$employee->name}}</h1>
                        <p class="">Email: <span class="text-seagreen">{{$employee->email}}</span></p>
                        <p class="">Phone: <span class="text-seagreen">{{$employee->phone ? $employee->phone :''}}</span></p>
                        <p class="">NID: <span class="text-seagreen">{{$employee->nid ? $employee->nid :''}}</span></p>
                        <p class="">Employee ID: <span class="text-seagreen">{{$employee->emp_id ? $employee->emp_id :''}}</span></p>
                        <p class="">Employee Number: <span class="text-seagreen">{{$employee->emp_number ? $employee->emp_number :''}}</span></p>
                        <p class="">Created At: <span class="text-seagreen">{{ date('d-M-Y', strtotime($employee->created_at)); }}</span></p>
                        <p class="">Last Updated At: <span class="text-seagreen">{{$employee->updated_at}}</span></p>
                        <p class="">Score : <span class="text-seagreen">{{$employee->score}}</span></p>
                        <p class="">Score Note : <span class="text-seagreen">{{$employee->score_note}}</span></p>
                    </div>
                </div>

            </div>
        </div> <!-- end card -->
    </div>


    <x-slot name="script">
        <script>
        </script>
    </x-slot>
</x-app-layout>



