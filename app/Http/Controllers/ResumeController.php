<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ResumeController extends Controller
{
    public function index()
    {
        return view('resume.index');
    }
    public function getData()
    {
        $data = Resume::latest()->get();

        return DataTables::of($data)
            ->addColumn('actions', function ($row) {
                return '
                    <a href="'.route('resume.edit', $row->id).'" class="text-blue-600 hover:text-blue-900">Edit</a>
                    <button class="delete-btn text-red-600 hover:text-red-900 ml-2" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['image', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('resume.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Resume::create($validated);

        return response()->json(['success' => true, 'message' => 'Entry created successfully!']);
    }

    public function edit($id)
    {
        $resume = Resume::findOrFail($id);
        return view('resume.edit', compact('resume'));
    }

    public function update(Request $request, $id)
    {
        $resume = Resume::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $resume->update($validated);
        return response()->json(['success' => true, 'message' => 'Entry updated successfully!']);
    }

    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);
        $resume->delete();
        return response()->json(['success' => true, 'message' => 'Entry deleted successfully!']);
    }
}
