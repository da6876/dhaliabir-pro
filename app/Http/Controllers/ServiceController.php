<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    // Display the service management page
    public function index()
    {
        return view('services.index');
    }

    // Fetch service data for DataTables
    public function getData()
    {
        $data = Service::latest()->get();

        return DataTables::of($data)
            ->addColumn('actions', function ($row) {
                return '
                    <a href="'.route('services.edit', $row->id).'" class="text-blue-600 hover:text-blue-900">Edit</a>
                    <button class="delete-btn text-red-600 hover:text-red-900 ml-2" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // Show create form
    public function create()
    {
        return view('services.create');
    }

    // Store new service
    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        Service::create($validated);

        return response()->json(['success' => true, 'message' => 'Service created successfully!']);
    }

    // Show edit form
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    // Update service
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $service->update($validated);

        return response()->json(['success' => true, 'message' => 'Service updated successfully!']);
    }

    // Delete service
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['success' => true, 'message' => 'Service deleted successfully!']);
    }
}
