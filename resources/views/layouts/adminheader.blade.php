<header class="app-header">
    <div class="flex items-center px-6 gap-3">
        <!-- Brand Logo -->
        <a href="index.html" class="logo-box">
            <!-- Light Brand Logo -->
            <div class="logo-light">
                <img src="{{asset('admindash/asset/css/app.min.css')}}assets/images/logo-light.png" class="logo-lg" alt="Light logo">
                <img src="{{asset('admindash/asset/css/app.min.css')}}assets/images/logo-sm.png" class="logo-sm" alt="Small logo">
            </div>

            <!-- Dark Brand Logo -->
            <div class="logo-dark">
                <img src="{{asset('admindash/asset/css/app.min.css')}}assets/images/logo-dark.png" class="logo-lg" alt="Dark logo">
                <img src="{{asset('admindash/asset/css/app.min.css')}}assets/images/logo-sm.png" class="logo-sm" alt="Small logo">
            </div>
        </a>

        <!-- Sidenav Menu Toggle Button -->
        <button id="button-toggle-menu" class="nav-link p-2">
            <span class="sr-only">Menu Toggle Button</span>
            <span class="flex items-center justify-center h-6 w-6">
                <i data-lucide="menu" class="w-6 h-6 text-xl"></i>
            </span>
        </button>

        <!-- Page Title -->
        <div class="me-auto">
            <div class="md:flex hidden">
                <h4 class="page-title text-lg capitalize">@if (isset($title)) {{ $title }} @endif</h4>
            </div>
        </div>



        <!-- Light/Dark Toggle Button -->
        <div class="flex">
            <button id="light-dark-mode" type="button" class="nav-link p-2">
                <span class="sr-only">Light/Dark Mode</span>
                <span class="flex items-center justify-center h-6 w-6">
                    <i data-lucide="moon" class="block dark:hidden"></i>
                    <i data-lucide="sun" class="hidden dark:block"></i>
                </span>
            </button>
        </div>


        <!-- Profile Dropdown Button -->
        <div class="relative">
            <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link flex items-center">
                <span class="text-sm mx-2">{{Auth::user()->name}}</span>
                <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-44 z-50 transition-[margin,opacity] duration-300 bg-white shadow-lg border rounded py-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">

                <a class="flex items-center py-2 px-5 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{route('profile.edit')}}">
                    <i data-lucide="user" class="w-4 h-4 me-2"></i>
                    <span>Profile</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="w-full flex items-center py-2 px-5 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                        <i data-lucide="log-out" class="w-4 h-4 me-2"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
