<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EducationController extends Controller
{
    // Display Education index page
    public function index()
    {
        return view('education.index');
    }

    // Server-side DataTables method
    public function getData()
    {
        $data = Education::latest()->get();

        return DataTables::of($data)
            ->addColumn('degree', fn($row) => $row->degree)
            ->addColumn('institute', fn($row) => $row->institute)
            ->addColumn('location', fn($row) => $row->location ?? '<span class="text-gray-400 text-xs">N/A</span>')
            ->addColumn('duration', fn($row) => $row->start_year . ' - ' . ($row->end_year ?? 'Present'))
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
                    <a href="'.route('education.edit', $row->id).'" class="text-blue-600 hover:text-blue-900">Edit</a>
                    <button class="delete-btn text-red-600 hover:text-red-900 ml-2" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['location', 'responsibilities', 'skills', 'actions'])
            ->make(true);
    }

    // Show Create Form
    public function create()
    {
        return view('education.create');
    }

    // Store new Education
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resume_id' => 'nullable|exists:resumes,id',
            'degree' => 'required|string|max:255',
            'institute' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_year' => 'required|string|max:10',
            'end_year' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|string',
        ]);

        // Assign a default resume_id if not provided
        $validated['resume_id'] = $validated['resume_id'] ?? 2; // change 1 to any default resume ID

        Education::create($validated);

        return response()->json(['success' => true, 'message' => 'Education added successfully!']);
    }


    // Show Edit Form
    public function edit($id)
    {
        $education = Education::findOrFail($id);
        return view('education.edit', compact('education'));
    }

    // Update Education
    public function update(Request $request, $id)
    {
        $education = Education::findOrFail($id);

        $validated = $request->validate([
            'resume_id' => 'nullable|exists:resumes,id',
            'degree' => 'required|string|max:255',
            'institute' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_year' => 'required|string|max:10',
            'end_year' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|string',
        ]);

        // Assign a default resume_id if not provided
        $validated['resume_id'] = $validated['resume_id'] ?? 2; // change 1 to your default resume ID

        $education->update($validated);

        return response()->json(['success' => true, 'message' => 'Education updated successfully!']);
    }


    // Delete Education
    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        $education->delete();

        return response()->json(['success' => true, 'message' => 'Education deleted successfully!']);
    }
}
