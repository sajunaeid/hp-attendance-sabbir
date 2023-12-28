<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Edit {{$role->nem}} Role</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">

                <form action="{{ route('roles.update', $role->id) }}" method="post">
                    <div class="grid lg:grid-cols-2 gap-5">
                        @csrf
                        @method('PATCH')


                        <div>
                            <label for="name" class="block mb-2">Name</label>
                            <input type="text" class="form-input" id="name" name="name" required value="{{$role->name}}">
                        </div> <!-- end -->

                        <div>
                            <label for="guard_name" class="block mb-2">Guard Name</label>
                            <select class="form-select" id="guard_name" name="guard_name" required>
                                <option value="web" selected>Web</option>
                                <option value="api" disabled>API</option>
                            </select>
                        </div> <!-- end -->


                        <div class="flex flex-wrap lg:col-span-2">
                            <input type="checkbox" class="form-checkbox rounded text-primary" id="checkAllPermission" >
                            <label class="ms-1.5" for="checkAllPermission" id="checkAllPermissionlable">Select All Permission</label>
                        </div>
                        <hr class="lg:col-span-2">

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 lg:col-span-2">
                            @foreach ($permissions as $permission)
                            <div class="flex items-center @if ($loop->first) col-span-2 sm:col-span-3 lg:col-span-4 @endif" >
                                <input type="checkbox" class="form-checkbox rounded text-primary permission" name="permission[]" id="InlineCheckbox{{$permission->id}}" value="{{$permission->id}}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : 'false'}}>
                                <label class="ms-1.5" for="InlineCheckbox{{$permission->id}}">{{$permission->name}}</label>
                            </div>
                            @endforeach
                        </div>





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
