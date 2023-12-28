<x-app-layout>
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

            <div class="grid xl:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-6">

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="card-title">Sales Analytics</h4>

                            <div>
                                <button data-fc-target="dropdown-target2" data-fc-type="dropdown" type="button" data-fc-placement="bottom-end">
                                    <i class="mdi mdi-dots-vertical text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="bg-success text-white rounded-full text-xs px-2 py-0.5">32% <i class="mdi mdi-trending-up"></i></div>

                            <div class="text-end">
                                <h2 class="text-3xl font-normal text-gray-800 dark:text-white mb-1"> 8451 </h2>
                                <p class="text-gray-400 font-normal">Revenue today</p>
                            </div>

                        </div>

                        <div class="flex w-full h-[5px] bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 mt-6">
                            <div class="flex flex-col justify-center overflow-hidden bg-success" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="flex flex-col justify-center overflow-hidden bg-success/10" role="progressbar" style="width: 25%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div> <!-- card-end -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="card-title">Sales Analytics</h4>

                            <div>
                                <button data-fc-target="dropdown-target2" data-fc-type="dropdown" type="button" data-fc-placement="bottom-end">
                                    <i class="mdi mdi-dots-vertical text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="bg-success text-white rounded-full text-xs px-2 py-0.5">32% <i class="mdi mdi-trending-up"></i></div>

                            <div class="text-end">
                                <h2 class="text-3xl font-normal text-gray-800 dark:text-white mb-1"> 8451 </h2>
                                <p class="text-gray-400 font-normal">Revenue today</p>
                            </div>

                        </div>

                        <div class="flex w-full h-[5px] bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 mt-6">
                            <div class="flex flex-col justify-center overflow-hidden bg-success" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="flex flex-col justify-center overflow-hidden bg-success/10" role="progressbar" style="width: 25%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div> <!-- card-end -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="card-title">Sales Analytics</h4>

                            <div>
                                <button data-fc-target="dropdown-target2" data-fc-type="dropdown" type="button" data-fc-placement="bottom-end">
                                    <i class="mdi mdi-dots-vertical text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="bg-success text-white rounded-full text-xs px-2 py-0.5">32% <i class="mdi mdi-trending-up"></i></div>

                            <div class="text-end">
                                <h2 class="text-3xl font-normal text-gray-800 dark:text-white mb-1"> 8451 </h2>
                                <p class="text-gray-400 font-normal">Revenue today</p>
                            </div>

                        </div>

                        <div class="flex w-full h-[5px] bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 mt-6">
                            <div class="flex flex-col justify-center overflow-hidden bg-success" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="flex flex-col justify-center overflow-hidden bg-success/10" role="progressbar" style="width: 25%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div> <!-- card-end -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="card-title">Sales Analytics</h4>

                            <div>
                                <button data-fc-target="dropdown-target2" data-fc-type="dropdown" type="button" data-fc-placement="bottom-end">
                                    <i class="mdi mdi-dots-vertical text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="bg-success text-white rounded-full text-xs px-2 py-0.5">32% <i class="mdi mdi-trending-up"></i></div>

                            <div class="text-end">
                                <h2 class="text-3xl font-normal text-gray-800 dark:text-white mb-1"> 8451 </h2>
                                <p class="text-gray-400 font-normal">Revenue today</p>
                            </div>

                        </div>

                        <div class="flex w-full h-[5px] bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 mt-6">
                            <div class="flex flex-col justify-center overflow-hidden bg-success" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="flex flex-col justify-center overflow-hidden bg-success/10" role="progressbar" style="width: 25%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div> <!-- card-end -->
            </div> <!-- grid-end -->

        </div> <!-- flex-end -->
    </div>
</x-app-layout>
