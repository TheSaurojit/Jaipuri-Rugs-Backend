<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\Request;

class ProductCollectionController extends Controller
{
    public function index()
    {
        $collections = ProductCollection::withCount('products')->latest()->get();
        return view('pages.product-collections.all-collections', compact('collections'));
    }

    public function create()
    {
        $products = Product::all(); // You might want to select specific fields or paginate
        return view('pages.product-collections.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $collection = ProductCollection::create([
            'name' => $request->input('name'),
        ]);

        if ($request->has('products')) {
            $collection->products()->attach($request->input('products'));
        }

        return redirect()->route('product-collections.index')->with('success', 'Collection created successfully.');
    }

    public function edit(ProductCollection $product_collection)
    {
        $products = Product::all();
        $selectedProducts = $product_collection->products->pluck('id')->toArray();
        return view('pages.product-collections.update', ['collection' => $product_collection, 'products' => $products, 'selectedProducts' => $selectedProducts]);
    }

    public function update(Request $request, ProductCollection $product_collection)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $product_collection->update([
            'name' => $request->input('name'),
        ]);

        if ($request->has('products')) {
            $product_collection->products()->sync($request->input('products'));
        } else {
            $product_collection->products()->detach();
        }

        return redirect()->route('product-collections.index')->with('success', 'Collection updated successfully.');
    }

    public function destroy(ProductCollection $product_collection)
    {
        $product_collection->delete();
        return redirect()->route('product-collections.index')->with('success', 'Collection deleted successfully.');
    }
}
