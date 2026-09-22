@extends('layouts.app')

@section('title', 'Create Portfolio')
@section('page-title', 'Add Portfolio Entry')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form id="createForm" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="App, Web, Card">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Order</label>
                    <input type="number" name="order" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Link</label>
                    <input type="url" name="link" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="10" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md text-sm font-medium">Save</button>
                <a href="{{ route('portfolio.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));

        $('#createForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.set('description', document.querySelector('#description').value);

            $.ajax({
                url: "{{ route('portfolio.store') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    alert(res.message);
                    window.location.href = "{{ route('portfolio.index') }}";
                },
                error: function(err) {
                    console.log(err);
                    alert('Something went wrong.');
                }
            });
        });
    </script>
@endpush
