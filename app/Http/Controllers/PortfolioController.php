<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('portfolio.index');
    }

    public function getData()
    {
        $data = Portfolio::latest()->get();

        return DataTables::of($data)
            ->addColumn('image', function ($row) {
                return $row->image ? '<img src="'.asset($row->image).'" width="80" />' : '';
            })
            ->addColumn('actions', function ($row) {
                return '
                    <a href="'.route('portfolio.edit', $row->id).'" class="text-blue-600 hover:text-blue-900">Edit</a>
                    <button class="delete-btn text-red-600 hover:text-red-900 ml-2" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['image', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('portfolio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/portfolio', 'public');
            $validated['image'] = 'storage/'.$path;
        }

        Portfolio::create($validated);

        return response()->json(['success' => true, 'message' => 'Portfolio entry created successfully!']);
    }

    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/portfolio', 'public');
            $validated['image'] = 'storage/'.$path;
        }

        $portfolio->update($validated);

        return response()->json(['success' => true, 'message' => 'Portfolio entry updated successfully!']);
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        // Optional: delete old image file
        if ($portfolio->image && file_exists(public_path($portfolio->image))) {
            unlink(public_path($portfolio->image));
        }

        $portfolio->delete();

        return response()->json(['success' => true, 'message' => 'Portfolio entry deleted successfully!']);
    }
}
