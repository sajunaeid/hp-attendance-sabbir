<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{$project->name}}</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <span class="inline-flex items-center gap-1.5 py-0.5 text-xs font-medium bg-seagreen text-white px-2">#{{$project->category->name}}</span>

                    <div class="flex gap-4">

                        <a href="{{route('projectmembers.create',$project->slug)}}">
                            <button type="button" class="btn border-seagreen text-seagreen hover:bg-seagreen hover:text-white">Manage Member</button>
                        </a>
                        <a href="{{route('projects.edit',$project->slug)}}">
                            <button type="button" class="btn bg-seagreen text-white">Edit</button>
                        </a>
                    </div>
                </div>
                <p class="text-lg font-medium mt-4">Keywords</p>
                <p class="border rounded p-4 mt-4">{{$project->keywords}}</p>
                <p class="mt-4 text-lg font-medium">Tools and technologies</p>
                <p class="border rounded p-4 mt-4">{{$project->tools}}</p>
                <p class="mt-4 text-lg font-medium">Description</p>
                <p class="border rounded p-4 mt-4">{!!$project->description!!}</p>
                <p class="mt-4 text-lg font-medium">Live preview link</p>
                <p class="border rounded p-4 mt-4">{{$project->link}}</p>

            </div>
        </div> <!-- end card -->

        <div class="card">
            <div class="p-6">
                <p class="text-lg font-medium">Images</p>
                <div class="grid lg:grid-cols-3">

                    @if ($project->cover_home)
                    <div class="">
                        <p>Home Page Cover</p>
                        <img src="{{asset($project->cover_home)}}" alt="" srcset="" class="w-full">
                    </div>
                    @endif

                    @if ($project->cover_work)
                    <div class="">
                        <p>Work Page Cover</p>
                        <img src="{{asset($project->cover_work)}}" alt="" srcset="" class="w-full">
                    </div>
                    @endif

                    @if ($project->cover_details)
                    <div class="">
                        <p>Details Page Cover</p>
                        <img src="{{asset($project->cover_details)}}" alt="" srcset="" class="w-full">
                    </div>
                    @endif
                </div>


            </div>
        </div> <!-- end card -->



    </div>


    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $("form #name").on('blur', () => {
                    const slug = slugify($("form #name").val());
                    $("form #slug").val(slug);
                });
            });
        </script>
    </x-slot>
</x-app-layout>



