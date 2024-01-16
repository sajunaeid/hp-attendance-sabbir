<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit {{$employee->name}} Employee</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">

                <form action="{{ route('employees.update',$employee->id) }}" method="post" enctype="multipart/form-data">
                    <div class="grid lg:grid-cols-2 gap-5">
                        @csrf
                        @method('PATCH')


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

                        <div>
                            <label for="wh" class="block mb-2">Working Hour</label>
                            <input type="number" class="form-input" id="wh" name="wh" required step="1" value="{{$employee->wh }}">
                        </div> <!-- end -->

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
        <script>
            // $(document).ready(function() {
            //     $("form #name").on('blur', () => {
            //         const slug = slugify($("form #name").val());
            //         $("form #slug").val(slug);
            //     });
            // });
        </script>
    </x-slot>
</x-app-layout>
