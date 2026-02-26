<?php

namespace App\Http\Controllers;

use App\Models\Shape;
use Illuminate\Http\Request;

class ShapeController extends Controller
{
    public function index()
    {
        $shapes = Shape::latest()->get();
        return view('pages.shapes.index', compact('shapes'));
    }

    public function create()
    {
        return view('pages.shapes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Shape::create($request->all());

        return redirect()->route('shapes.index')->with('success', 'Shape created successfully.');
    }

    public function edit(Shape $shape)
    {
        return view('pages.shapes.edit', compact('shape'));
    }

    public function update(Request $request, Shape $shape)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $shape->update($request->all());

        return redirect()->route('shapes.index')->with('success', 'Shape updated successfully.');
    }

    public function destroy(Shape $shape)
    {
        $shape->delete();
        return redirect()->route('shapes.index')->with('success', 'Shape deleted successfully.');
    }
}
