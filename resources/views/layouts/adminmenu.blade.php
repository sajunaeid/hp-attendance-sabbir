<div class="app-menu">



    <!-- Sidenav Brand Logo -->
    <a href="{{route('home')}}" class="p-2">

        <!-- Dark Brand Logo -->
        <div class="flex justify-center items-center">
            <img src="{{asset('hp.svg')}}" class="h-10" alt="Hahneman Pharmacy">
        </div>
    </a>



    <!--- Menu -->
    <div data-simplebar="">

        <ul class="menu" data-fc-type="accordion">
            <li class="menu-title">Navigation</li>


            <li class="menu-item">
                <a href="{{route('dashboard')}}" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-view-dashboard"></i></span>
                    <span class="menu-text"> Dashboard </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-account-star"></i></span>
                    <span class="menu-text"> Employees </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{route('employees.index')}}" class="menu-link">
                            <span class="menu-text">All Employees</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('employees.create')}}" class="menu-link">
                            <span class="menu-text">New Employee</span>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                        <a href="{{route('users.index')}}" class="menu-link">
                            <span class="menu-text">User Trash</span>
                        </a>
                    </li> --}}
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-fax"></i></span>
                    <span class="menu-text"> Reports </span>
                    <span class="menu-arrow"></span>
                </a>


                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{route('reports.daily')}}" class="menu-link">
                            <span class="menu-text">Daily</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('reports.weekly')}}" class="menu-link">
                            <span class="menu-text">Weekly</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('reports.monthly')}}" class="menu-link">
                            <span class="menu-text">Monthly</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('reports.yearly')}}" class="menu-link">
                            <span class="menu-text">Yearly</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('reports.range')}}" class="menu-link">
                            <span class="menu-text">Custom</span>
                        </a>
                    </li>
                </ul>
            </li>



            @role('admin')
            <li class="menu-title">Management</li>
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-account-supervisor-outline"></i></span>
                    <span class="menu-text"> Users </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{route('users.index')}}" class="menu-link">
                            <span class="menu-text">All User</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('users.create')}}" class="menu-link">
                            <span class="menu-text">New User</span>
                        </a>
                    </li>
                    {{-- <li class="menu-item">
                        <a href="{{route('users.index')}}" class="menu-link">
                            <span class="menu-text">User Trash</span>
                        </a>
                    </li> --}}
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-account-lock-open-outline"></i></span>
                    <span class="menu-text"> Role & Permission </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="sub-menu hidden">
                    <li class="menu-item">
                        <a href="{{route('roles.index')}}" class="menu-link">
                            <span class="menu-text">All Role</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('roles.create')}}" class="menu-link">
                            <span class="menu-text">New Role</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('permissions.index')}}" class="menu-link">
                            <span class="menu-text">Permissions</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole

        </ul>
    </div>
</div>
