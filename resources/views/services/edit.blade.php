@extends('layouts.app')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service Entry')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form id="editServiceForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title"
                           value="{{ $service->title }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Icon (Bootstrap Icon class)</label>
                    <input type="text" name="icon"
                           value="{{ $service->icon }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Link</label>
                    <input type="text" name="link"
                           value="{{ $service->link }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Order</label>
                    <input type="number" name="order" min="0"
                           value="{{ $service->order }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="10"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">{!! $service->description !!}</textarea>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md text-sm font-medium">
                    Update
                </button>
                <a href="{{ route('services.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- CKEditor 5 --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

    <script>
        let editor;

        // Initialize CKEditor with existing description
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        // Handle AJAX update form
        $('#editServiceForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            // Get CKEditor data
            formData.set('description', editor.getData());

            $.ajax({
                url: "{{ route('services.update', $service->id) }}",
                method: 'POST', // Laravel requires POST + _method=PUT
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    alert(res.message);
                    window.location.href = "{{ route('services.index') }}";
                },
                error: function(err) {
                    console.log(err);
                    alert('Something went wrong while updating.');
                }
            });
        });
    </script>
@endpush
