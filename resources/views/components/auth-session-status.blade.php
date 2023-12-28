@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'bg-seagreen/40 backdrop-blur-sm px-4 py-2 font-medium text-sm text-white absolute top-4 right-6 z-[11111] hover:bg-seagreen']) }}>
        <div class="flex gap-4">

            <p>{{ $status }}</p>


            <span class="menu-icon"><i class="mdi mdi-close"></i></span>
        </div>
    </div>
@endif

