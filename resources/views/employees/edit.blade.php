<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit {{$employee->name}} Employee</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        <!-- Style -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">

                <form action="{{ route('employees.update',$employee->id) }}" method="post" enctype="multipart/form-data">
                    <div class="grid lg:grid-cols-2 gap-5">
                        @csrf
                        @method('PATCH')
                        <div class="col-span-2 flex items-end gap-5">
                            <img src="{{$employee->pp ? asset($employee->pp) :'https://picsum.photos/200'}}" alt="" srcset="">
                            <div class="">
                                <label for="pp" class="block mb-2">Profile Picture</label>
                                <input type="file" name="pp" id="pp"  class="form-input">
                            </div>
                        </div>


                        <div>
                            <label for="name" class="block mb-2">Name</label>
                            <input type="text" class="form-input" id="name" name="name" required value="{{$employee->name }}">
                        </div> <!-- end -->

                        <div>
                            <label for="phone" class="block mb-2">Phone</label>
                            <input type="text" class="form-input" id="phone" name="phone" required value="{{$employee->phone }}">
                        </div> <!-- end -->

                        <div>
                            <label for="nid" class="block mb-2">NID</label>
                            <input type="text" class="form-input" id="nid" name="nid" required value="{{$employee->nid }}">
                        </div> <!-- end -->

                        <div>
                            <label for="emp_id" class="block mb-2">Employee ID</label>
                            <input type="text" class="form-input" id="emp_id" name="emp_id" required value="{{$employee->emp_id }}" maxlength="9">
                        </div> <!-- end -->

                        <div>
                            <label for="emp_number" class="block mb-2">Employee Number</label>
                            <input type="text" class="form-input" id="emp_number" name="emp_number" required value="{{$employee->emp_number }}">
                        </div> <!-- end -->


                        <div class="flex gap-4">

                            <div>
                                <label for="wh" class="block mb-2">Working Hour</label>
                                <input type="number" class="form-input" id="wh" name="wh" required step="1" value="{{$employee->wh }}">
                            </div> <!-- end -->


                            <div class="flex-grow">
                                <label for="we" class="block mb-2">Working Hour</label>
                                @php
                                    $weekends = json_decode($employee->we);
                                @endphp
                                <select class="form-input text-gray-900 dark:text-gray-900" name="we[]" multiple id="we">
                                    <option value="Saturday" {{ in_array('Saturday', $weekends) ? 'selected' : '' }}>Saturday</option>
                                    <option value="Sunday" {{ in_array('Sunday', $weekends) ? 'selected' : '' }}>Sunday</option>
                                    <option value="Monday" {{ in_array('Monday', $weekends) ? 'selected' : '' }}>Monday</option>
                                    <option value="Tuesday" {{ in_array('Tuesday', $weekends) ? 'selected' : '' }}>Tuesday</option>
                                    <option value="Wednesday" {{ in_array('Wednesday', $weekends) ? 'selected' : '' }}>Wednesday</option>
                                    <option value="Thursday" {{ in_array('Thursday', $weekends) ? 'selected' : '' }}>Thursday</option>
                                    <option value="Friday" {{ in_array('Friday', $weekends) ? 'selected' : '' }}>Friday</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="score" class="block mb-2">Score</label>
                            <input type="text" class="form-input" id="score" name="score" required value="{{$employee->score }}">
                        </div> <!-- end -->

                        <div>
                            <label for="score_note" class="block mb-2">Score Note</label>
                            <textarea class="form-input" id="score_note" name="score_note" required rows="1">{{$employee->score_note }}</textarea>
                        </div> <!-- end -->


                        <div>
                            <p class="mt-auto">All filds are required. Pleaser fill them all before submit/save.</p>
                        </div> <!-- end -->



                        <div class="lg:col-span-2 mt-3">
                            <button type="submit"
                                class="font-mont mt-8 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Update</button>
                        </div> <!-- end button -->
                    </div>
                </form>

            </div>
        </div> <!-- end card -->



    </div>


    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#we').select2();
            });
        </script>
    </x-slot>
</x-app-layout>
