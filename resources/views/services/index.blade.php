@extends('layouts.app')

@section('title', 'Services')
@section('page-title', 'Services List')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Services</h2>
            <a href="{{ route('services.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Add New
            </a>
        </div>

        <div class="overflow-x-auto">
            <table id="servicesTable" class="min-w-full divide-y divide-gray-200 w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Icon</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Link</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
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
            let table = $('#servicesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('services.data') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'icon', name: 'icon' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'link', name: 'link' },
                    { data: 'order', name: 'order' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ]
            });

            // Delete
            $(document).on('click', '.delete-btn', function() {
                if (!confirm('Delete this service?')) return;
                let id = $(this).data('id');

                $.ajax({
                    url: `/services/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res) {
                        alert(res.message);
                        table.ajax.reload();
                    }
                });
            });
        });
    </script>
@endpush
