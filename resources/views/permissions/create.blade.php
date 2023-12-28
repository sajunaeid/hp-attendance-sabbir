<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Create Project</x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="p-6">

                <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
                    <div class="grid lg:grid-cols-2 gap-5">
                        @csrf
                        @method('post')


                        <div>
                            <label for="name" class="block mb-2">Name</label>
                            <input type="text" class="form-input" id="name" name="name" required>
                        </div> <!-- end -->

                        <div>
                            <label for="slug" class="block mb-2">Slug</label>
                            <input type="text" class="form-input" id="slug" name="slug" required=""
                                readonly>
                        </div> <!-- end -->

                        <div>
                            <label for="client" class="block mb-2">Client</label>
                            <input type="text" class="form-input" id="client" name="client"
                                >
                        </div> <!-- end -->

                        <div>
                            <label for="keywords" class="block mb-2">Keywords</label>
                            <input type="text" class="form-input" id="keywords" name="keywords" required="">
                        </div> <!-- end -->

                        <div>
                            <label for="tools" class="block mb-2">Tools</label>
                            <input type="text" class="form-input" id="tools" name="tools" required="">
                        </div> <!-- end -->

                        <div>
                            <label for="category_id" class="block mb-2">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option selected="" disabled value="">Choose...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="start_date">Start Date</label>
                            <input class="form-input" id="start_date" type="date" name="start_date">
                        </div> <!-- end -->
                        <div>
                            <label class="block text-gray-600 mb-2" for="delivery_date">Delivery Date</label>
                            <input class="form-input" id="delivery_date" type="date" name="delivery_date">
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="description">Description</label>
                            <textarea class="form-input" id="description" rows="5" name="description"></textarea>
                        </div> <!-- end -->

                        <div>
                            <label for="link" class="block mb-2">Live Preview</label>
                            <input type="text" class="form-input" id="link" name="link" required="">
                        </div> <!-- end -->


                        <div>
                            <label class="block text-gray-600 mb-2" for="cover_home">Home Page Cover</label>
                            <input type="file" id="cover_home" class="form-input border" name="cover_home">
                        </div> <!-- end -->
                        <div>
                            <label class="block text-gray-600 mb-2" for="cover_work">Work Page Cover</label>
                            <input type="file" id="cover_work" class="form-input border" name="cover_work">
                        </div> <!-- end -->
                        <div>
                            <label class="block text-gray-600 mb-2" for="cover_details">Details Page Cover</label>
                            <input type="file" id="cover_details" class="form-input border" name="cover_details">
                        </div> <!-- end -->



                        <div class="lg:col-span-2 mt-3">
                            <button type="submit"
                                class="font-mont mt-8 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SAVE'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Save</button>
                        </div> <!-- end button -->


                    </div>
                </form>

            </div>
        </div> <!-- end card -->



    </div>


    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $("form #name").on('blur', () => {
                    const slug = slugify($("form #name").val());
                    $("form #slug").val(slug);
                });
            });
        </script>
    </x-slot>
</x-app-layout>
