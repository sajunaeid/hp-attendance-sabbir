<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$employee->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="h-40 rounded-sm bg-no-repeat bg-cover bg-center" style="background-image: url('https://picsum.photos/1080/720')"></div>
            <div class="px-6 pb-6 -mt-14">
                <div class="flex justify-between items-end">
                    <div class="">
                        <div class="p-1 w-36 h-36 bg-no-repeat bg-cover bg-center border border-white relative shadow-md" style="background-image: url({{$employee->pp ? asset($employee->pp) :'https://picsum.photos/200'}})">
                            <span class="text-seagreen bg-white rounded-full py-1 px-2 absolute -top-3 -right-4 shadow-md border border-seagreen">{{$employee->score}}</span>
                        </div>
                        <h1 class="text-2xl font-semibold mt-4 capitalize">{{$employee->name}}</h1>
                    </div>
                    <div class="flex justify-between items-center mt-4">

                        <div class="flex gap-4">
                            <a href="{{route('employees.edit',$employee->id)}}">
                                <button type="submit" class="font-mont px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Edit</button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-start mt-4 gap-4">
                    <div class="">
                        <p class="mt-4">Phone: <span class="text-seagreen">{{$employee->phone ? $employee->phone :''}}</span></p>
                        <p class="">NID: <span class="text-seagreen">{{$employee->nid ? $employee->nid :''}}</span></p>
                        <p class="">Employee ID: <span class="text-seagreen">{{$employee->emp_id ? $employee->emp_id :''}}</span></p>
                        <p class="">Employee Number: <span class="text-seagreen">{{$employee->emp_number ? $employee->emp_number :''}}</span></p>
                        <p class="">Created At: <span class="text-seagreen">{{ date('d-M-Y', strtotime($employee->created_at)); }}</span></p>
                        <p class="">Last Updated At: <span class="text-seagreen">{{$employee->updated_at}}</span></p>

                    </div>
                    <div class=" basis-1/4">
                        <div class="grid grid-cols-3 gap-1">
                            @php
                                $weekends = json_decode($employee->we);
                            @endphp
                            <span class="p-1 text-center {{ in_array('Saturday', $weekends) ? 'bg-red-400' : 'bg-green-400' }}">Saturday</span>
                            <span class="p-1 text-center {{ in_array('Sunday', $weekends) ? 'bg-red-400' : 'bg-green-400' }}">Sunday</span>
                            <span class="p-1 text-center {{ in_array('Monday', $weekends) ? 'bg-red-400' : 'bg-green-400' }}">Monday</span>
                            <span class="p-1 text-center {{ in_array('Tuesday', $weekends) ? 'bg-red-400' : 'bg-green-400' }}">Tuesday</span>
                            <span class="p-1 text-center {{ in_array('Wednesday', $weekends) ? 'bg-red-400' : 'bg-green-400' }}">Wednesday</span>
                            <span class="p-1 text-center {{ in_array('Thursday', $weekends) ? 'bg-red-400' : 'bg-green-400' }}">Thursday</span>
                            <span class="p-1 text-center {{ in_array('Friday', $weekends) ? 'bg-red-400' : 'bg-green-400' }}">Friday</span>
                        </div>
                        <p class="mt-4">Score Note : <span class="text-seagreen">{{$employee->score_note}}</span></p>
                    </div>
                </div>


            </div>


            <div class="mt-4 p-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6">

                    <div class="card p-6 shadow-md">
                        <form action="{{route('documents.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="">
                                <label for="">Document Name</label>
                                <input type="text" name="docname" id="" class="form-input mt-2" required>
                            </div>
                            <div class="mt-4">
                                <label for="">Document</label>
                                <input type="file" class="form-input mt-2" name="docpath" accept="image/jpg, image/jpeg" required>
                            </div>
                            <input type="hidden" name="employee_id" value="{{$employee->id}}" required>

                            <div class="flex justify-between items-center mt-4">
                                <button type="submit" class="font-mont px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Add</button>
                            </div>

                        </form>
                    </div>



                    @forelse ($employee->documents as $document)
                    {{-- individual document --}}
                    <div class="card p-6 shadow-md">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="">{{$document->docname}}</h3>
                            <div class="flex gap-2">
                                <form action="{{route('documents.destroy', $document)}}" method="DELETE">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl bg-gray-100 rounded-md p-1 aspect-square flex justify-center items-center" >
                                        <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </button>
                                </form>


                                <a href="{{route('documents.show',$document)}}">
                                    <button type="button"  class="text-blue-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl bg-gray-100 rounded-md p-1 aspect-square flex justify-center items-center" >
                                        <span class="menu-icon"><i class="mdi mdi-download"></i></span>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <img src="{{asset($document->docpath)}}" alt="" srcset="" class="w-full">
                    </div>
                    @empty
                    <div class="col-span-1 sm:col-span-3 flex justify-center items-center font-bold text-gray-400">

                        <p class="">No document found</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div> <!-- end card -->
    </div>


    <x-slot name="script">
        <script>
        </script>
    </x-slot>
</x-app-layout>



