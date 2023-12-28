<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$user->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div class="flex justify-start items-center gap-2">
                        @foreach ($user->roles as $role)

                        <span class="inline-flex items-center gap-1.5 py-0.5 text-xs font-medium bg-seagreen text-white px-2">{{$role->name}}</span>
                        @endforeach
                    </div>

                    <div class="flex gap-4">
                        <a href="{{route('users.edit',$user->id)}}">
                            <button type="submit" class="font-mont px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Edit</button>
                        </a>
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <h1 class="text-2xl font-semibold mt-4">{{$user->name}}</h1>
                        <p class="">Email: <span class="text-seagreen">{{$user->email}}</span></p>
                        <p class="">Created At: <span class="text-seagreen">{{$user->created_at}}</span></p>
                        <p class="">Updated At: <span class="text-seagreen">{{$user->updated_at}}</span></p>
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



