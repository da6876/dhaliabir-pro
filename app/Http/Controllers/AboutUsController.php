<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        return view('about.index');
    }
    public function getData()
    {
        $data = AboutUs::latest()->get();

        return DataTables::of($data)
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    return '<img src="'.asset('storage/'.$row->image).'" class="w-10 h-10 rounded object-cover">';
                }
                return '<span class="text-gray-400 text-xs">No Image</span>';
            })
            ->addColumn('actions', function ($row) {
                return '
                    <a href="'.route('about.edit', $row->id).'" class="text-blue-600 hover:text-blue-900">Edit</a>
                    <button class="delete-btn text-red-600 hover:text-red-900 ml-2" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['image', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('about.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('about', 'public');
            $validated['image'] = asset('' . $path); // store full URL
        }

        AboutUs::create($validated);

        return response()->json(['success' => true, 'message' => 'Entry created successfully!']);
    }

    public function edit($id)
    {
        $about = AboutUs::findOrFail($id);
        return view('about.edit', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $about = AboutUs::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($about->image) {
                $oldPath = str_replace(asset('storage') . '/', '', $about->image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('about', 'public');
            $validated['image'] = asset('' . $path);
        }
        $about->update($validated);
        return response()->json(['success' => true, 'message' => 'Entry updated successfully!']);
    }

    public function destroy($id)
    {
        $about = AboutUs::findOrFail($id);
        if ($about->image) {
            $oldPath = str_replace(asset('storage') . '/', '', $about->image);
            Storage::disk('public')->delete($oldPath);
        }
        $about->delete();
        return response()->json(['success' => true, 'message' => 'Entry deleted successfully!']);
    }
}
