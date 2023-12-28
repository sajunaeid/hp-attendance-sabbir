<x-err-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div> -->
        <div class="flex flex-col gap-6">

            <div class="flex justify-center items-center">

                <div class="h-fit text-center">
                    <h1 class="font-bold text-red-500 text-8xl">404</h1>
                    <p class="font-semibold text-teal-500 text-xl">Not Found.</p>
                </div> <!-- card-end -->


            </div> <!-- grid-end -->

        </div> <!-- flex-end -->
    </div>
</x-err-layout>
