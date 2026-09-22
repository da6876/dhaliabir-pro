@extends('layouts.app')

@section('title', 'Edit Education')
@section('page-title', 'Edit Education Entry')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form id="editEducationForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Degree</label>
                    <input type="text" name="degree"
                           value="{{ $education->degree }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Institute</label>
                    <input type="text" name="institute"
                           value="{{ $education->institute }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Start Year</label>
                    <input type="text" name="start_year"
                           value="{{ $education->start_year }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">End Year</label>
                    <input type="text" name="end_year"
                           value="{{ $education->end_year }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="6"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">{!! $education->description !!}</textarea>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md text-sm font-medium">
                    Update
                </button>
                <a href="{{ route('education.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

    <script>
        let editor;

        // Initialize CKEditor with existing description
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(newEditor => { editor = newEditor; })
            .catch(error => { console.error(error); });

        // Handle AJAX update form
        $('#editEducationForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.set('description', editor.getData());

            $.ajax({
                url: "{{ route('education.update', $education->id) }}",
                method: 'POST', // Laravel uses POST + _method=PUT
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    alert(res.message);
                    window.location.href = "{{ route('education.index') }}";
                },
                error: function(err) {
                    console.error(err);
                    alert('Something went wrong while updating.');
                }
            });
        });
    </script>
@endpush
