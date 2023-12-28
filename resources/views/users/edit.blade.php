<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit {{$user->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">

                <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                    <div class="grid lg:grid-cols-2 gap-5">
                        @csrf
                        @method('PATCH')


                        <div>
                            <label for="name" class="block mb-2">Name</label>
                            <input type="text" class="form-input" id="name" name="name" required value="{{$user->name}}">
                        </div> <!-- end -->

                        <div>
                            <label for="email" class="block mb-2">Email</label>
                            <input type="text" class="form-input" id="email" name="email" required="" value="{{$user->email}}">
                        </div> <!-- end -->



                        <div>
                            <label for="role" class="block mb-2">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                @foreach ($roles as $role)
                                    <option  value="{{ $role->name }}" @if(in_array($role->name, $userRole)) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
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
            $(document).ready(function() {
                $("form #name").on('blur', () => {
                    const slug = slugify($("form #name").val());
                    $("form #slug").val(slug);
                });
            });
        </script>
    </x-slot>
</x-app-layout>
