<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experience;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ExperienceController extends Controller
{
    public function index()
    {
        return view('experience.index');
    }
    public function getData()
    {
        $data = Experience::latest()->get();

        return DataTables::of($data)
            ->addColumn('responsibilities', function ($row) {
                if ($row->responsibilities && count($row->responsibilities) > 0) {
                    return implode(', ', $row->responsibilities);
                }
                return '<span class="text-gray-400 text-xs">None</span>';
            })
            ->addColumn('skills', function ($row) {
                if ($row->skills && count($row->skills) > 0) {
                    return implode(', ', $row->skills);
                }
                return '<span class="text-gray-400 text-xs">None</span>';
            })
            ->addColumn('actions', function ($row) {
                return '
                <a href="'.route('experience.edit', $row->id).'" class="text-blue-600 hover:text-blue-900">Edit</a>
                <button class="delete-btn text-red-600 hover:text-red-900 ml-2" data-id="'.$row->id.'">Delete</button>
            ';
            })
            ->rawColumns(['responsibilities', 'skills', 'actions'])
            ->make(true);
    }


    public function create()
    {
        return view('experience.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_year' => 'required|string|max:10',
            'end_year' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|string',
        ]);

        Experience::create($validated);

        return response()->json(['success' => true, 'message' => 'Experience added successfully!']);
    }

    public function edit($id)
    {
        $experience = Experience::findOrFail($id);
        return view('experience.edit', compact('experience'));
    }

    public function update(Request $request, $id)
    {
        $experience = Experience::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_year' => 'required|string|max:10',
            'end_year' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|string',
        ]);

        $experience->update($validated);

        return response()->json(['success' => true, 'message' => 'Experience updated successfully!']);
    }

    public function destroy($id)
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return response()->json(['success' => true, 'message' => 'Experience deleted successfully!']);
    }
}
