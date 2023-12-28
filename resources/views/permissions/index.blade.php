<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Permissions</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">
                <h2 class="mb-4 text-xl">New Permission</h2>

                <form class="" id="permissionCreateForm">

                    <div class="grid lg:grid-cols-2 gap-5">

                        <div>
                            <label for="name" class="block mb-2">Permission Name</label>
                            <input type="text" class="form-input" id="name" name="name"
                                placeholder="model-permission">
                        </div> <!-- end -->

                        <div>
                            <label for="guard" class="block mb-2">Guard Name</label>
                            <select class="form-select" id="guard" name="guard">
                                <option value="web" selected>web</option>
                                <option value="api" disabled>api</option>
                            </select>
                        </div> <!-- end -->

                        <div class="lg:col-span-2 ">
                            <button type="submit" class="font-mont mt-2 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300"
                                id="permissionSaveBtn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="p-6">
                <table id="permissionsTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Gurd</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


    </div>


    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            var datatablelist = $('#permissionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('permissions.index') !!}",
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
                        data: 'guard_name',
                        name: 'guard_name'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                <button type="button"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="permissionDelete(${data.id});">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });

            // Deleting Permission
            function permissionDelete(slug) {
                Swal.fire({
                    title: "Delete ?",
                    text: "Are you sure to delete this Permission ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Delete",
                    background: 'rgba(255, 255, 255, 0.6)',
                    padding: '20px',
                    confirmButtonColor: '#0db8a6',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            method: 'DELETE',
                            url: BASE_URL + 'permissions/' + slug,
                            success: function(response) {
                                if (response.success) {
                                    // Swal.fire('Success!', response.message, 'success');

                                    $("#ajaxflash div p").text(response.success);
                                    $("#ajaxflash").fadeIn().fadeOut(5000);

                                    datatablelist.draw();
                                } else {
                                    Swal.fire('Not deletable!', 'This permission is connected to a role.', 'error');
                                    datatablelist.draw();
                                }
                            }
                        });
                    }
                });
            }


            // Add New Permission
            $("form#permissionCreateForm").submit(function(e) {
                e.preventDefault();

                let name = $("#permissionCreateForm #name");

                if (name.val() != "") {
                    let nameValue = name.val();
                    let gurdname = $("#permissionCreateForm #guard").val();
                    $.ajax({
                        url: BASE_URL + 'permissions',
                        dataType: 'json',
                        data: {
                            name: nameValue,
                            guard_name: gurdname,
                        },
                        type: 'POST',
                        success: function(response) {
                            if (response.error) {
                                $("#ajaxflash div p").text(response.error);
                                $("#ajaxflash").fadeIn().fadeOut(5000);
                            } else {
                                $("#ajaxflash div p").text(response.success);
                                $("#ajaxflash").fadeIn().fadeOut(5000);
                                datatablelist.draw();
                                name.focus().val("");
                            }

                        },
                    });

                } else {
                    $("#ajaxflash div p").text('Name fild is required.');
                    $("#ajaxflash").fadeIn().fadeOut(5000);
                    name.focus();
                }
            });
        </script>
    </x-slot>
</x-app-layout>
