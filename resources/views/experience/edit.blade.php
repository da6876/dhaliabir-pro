@extends('layouts.app')

@section('title', 'Edit Experience')
@section('page-title', 'Edit Experience')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form id="editExperienceForm" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" value="{{ $experience->title }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Company</label>
                    <input type="text" name="company" value="{{ $experience->company }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" value="{{ $experience->location }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700">Start Year</label>
                        <input type="text" name="start_year" value="{{ $experience->start_year }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700">End Year</label>
                        <input type="text" name="end_year" value="{{ $experience->end_year }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="5"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                       focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">{!! $experience->description !!}</textarea>
            </div>

            <!-- Responsibilities -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mt-4">Responsibilities</label>
                <input type="text" id="responsibilitiesInput" placeholder="Type and separate by comma"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm">
                <div id="responsibilitiesTags" class="flex flex-wrap gap-2 mt-2"></div>
                <input type="hidden" name="responsibilities[]" id="responsibilitiesHidden">
            </div>

            <!-- Skills -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mt-4">Skills</label>
                <input type="text" id="skillsInput" placeholder="Type and separate by comma"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm">
                <div id="skillsTags" class="flex flex-wrap gap-2 mt-2"></div>
                <input type="hidden" name="skills[]" id="skillsHidden">
            </div>

            <div class="flex items-center gap-4 mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md text-sm">Update</button>
                <a href="{{ route('experience.index') }}" class="text-gray-600 hover:underline text-sm">Cancel</a>
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
        ClassicEditor.create(document.querySelector('#description'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => console.error(error));

        // Tag input logic
        function createTag(value, container, hiddenInput) {
            if (!value.trim()) return;
            const tag = $('<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm cursor-pointer">' + value.trim() + ' &times;</span>');
            tag.click(function() {
                $(this).remove();
                updateHidden(container, hiddenInput);
            });
            $(container).append(tag);
            updateHidden(container, hiddenInput);
        }

        function updateHidden(container, hiddenInput) {
            const values = [];
            $(container).children('span').each(function() {
                values.push($(this).text().slice(0, -2).trim());
            });
            $(hiddenInput).val(values.join(','));
        }

        // Populate existing responsibilities and skills
        let existingResponsibilities = {!! json_encode($experience->responsibilities) !!};
        existingResponsibilities.forEach(r => createTag(r, '#responsibilitiesTags', '#responsibilitiesHidden'));

        let existingSkills = {!! json_encode($experience->skills) !!};
        existingSkills.forEach(s => createTag(s, '#skillsTags', '#skillsHidden'));

        $('#responsibilitiesInput').on('keyup', function(e) {
            if (e.key === ',' || e.key === 'Enter') {
                const values = $(this).val().split(',');
                values.forEach(v => createTag(v, '#responsibilitiesTags', '#responsibilitiesHidden'));
                $(this).val('');
            }
        });

        $('#skillsInput').on('keyup', function(e) {
            if (e.key === ',' || e.key === 'Enter') {
                const values = $(this).val().split(',');
                values.forEach(v => createTag(v, '#skillsTags', '#skillsHidden'));
                $(this).val('');
            }
        });

        // AJAX update form submission
        $('#editExperienceForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.set('description', editor.getData());

            $.ajax({
                url: "{{ route('experience.update', $experience->id) }}",
                method: 'POST', // Laravel requires POST + _method=PUT
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    alert(res.message);
                    window.location.href = "{{ route('experience.index') }}";
                },
                error: function(err) {
                    console.error(err);
                    alert('Something went wrong while updating.');
                }
            });
        });
    </script>
@endpush
