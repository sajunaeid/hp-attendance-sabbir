<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$role->name}} Role</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">

                <div class="flex flex-wrap justify-between items-center">
                    <h3 class="font-semibold text-2xl">All Permission this Role has:</h3>
                    <a href="{{route('roles.edit',$role->id)}}">
                        <button type="submit"
                            class="font-mont px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">EDIT</button>
                    </a>
                </div>

                <hr class="mt-4">

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 lg:col-span-2 mt-4">
                    @foreach ($rolePermissions as $permission)
                    <div class="flex items-center @if ($loop->first) col-span-2 sm:col-span-3 lg:col-span-4 @endif" >
                        <p class="ms-1.5 capitalize">{{$permission->name}}</p>
                    </div>
                    @endforeach
                </div>

            </div>
        </div> <!-- end card -->



    </div>


    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // Check Uncheck All
                $('#checkAllPermission').click(function () {
                    $('.permission').prop('checked', this.checked);
                });

                $('.permission').change(function () {
                    var check = ($('.permission').filter(":checked").length == $('.permission').length);
                    $('#checkAllPermission').prop("checked", check);
                });
            });
        </script>
    </x-slot>
</x-app-layout>
