<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Users</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">
                <table id="userTable" class="display stripe text-xs sm:text-base" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
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
        {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> --}}
        <script>
            var datatablelist = $('#userTable').DataTable({
                dom: 'Bfrtip',
                // buttons: [
                //     'print'
                // ],
                processing: true,
                serverSide: true,
                ajax: "{!! route('users.index') !!}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'intro',
                        name: 'intro'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `<div class="flex flex-col sm:flex-row gap-5 justify-end items-center">
                                <a href="${BASE_URL}users/${data.id}" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-eye"></i></span>
                                </a>
                                <a href="${BASE_URL}users/${data.id}/edit" class="text-seagreen/70 hover:text-seagreen  hover:scale-105 transition duration-150 ease-in-out text-xl" >
                                    <span class="menu-icon"><i class="mdi mdi-table-edit"></i></span>
                                </a>
                                <button type="button"  class="text-red-500/70 hover:text-red  hover:scale-105 transition duration-150 ease-in-out text-xl" onclick="userDelete(${data.id});">
                                    <span class="menu-icon"><i class="mdi mdi-delete"></i></span>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });


            // var datatablelist = $('#userTable').DataTable();


            function userDelete(userID) {


                Swal.fire({
                    title: "Delete ?",
                    text: "Are you sure to delete this User ?",
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
                            url: BASE_URL + 'users/' + userID,
                            success: function(response) {
                                if (response.success) {
                                    $("#ajaxflash div p").text(response.success);
                                    $("#ajaxflash").fadeIn().fadeOut(5000);
                                    datatablelist.draw();
                                } else {
                                    Swal.fire('Not deletable!', 'Something is dependent on it.', 'error');
                                    datatablelist.draw();
                                }
                            }
                        });
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>
