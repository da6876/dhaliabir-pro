@extends('layouts.app')

@section('title', 'Education')
@section('page-title', 'Education List')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Education Entries</h2>
            <a href="{{ route('education.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Add New
            </a>
        </div>

        <div class="overflow-x-auto">
            <table id="educationTable" class="min-w-full divide-y divide-gray-200 w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Degree</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Institute</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Start Year</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">End Year</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            let table = $('#educationTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('education.data') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'degree', name: 'degree' },
                    { data: 'institute', name: 'institute' },
                    { data: 'start_year', name: 'start_year' },
                    { data: 'end_year', name: 'end_year' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ]
            });

            // Delete
            $(document).on('click', '.delete-btn', function() {
                if (!confirm('Delete this entry?')) return;
                let id = $(this).data('id');

                $.ajax({
                    url: `/education/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res) {
                        alert(res.message);
                        table.ajax.reload();
                    },
                    error: function(err) {
                        console.error(err);
                        alert('Failed to delete entry.');
                    }
                });
            });
        });
    </script>
@endpush
