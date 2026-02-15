<?php

namespace App\Http\Controllers;

use App\Helpers\FileUploader;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * @param UploadedFile[] $images
     */
    private  function uploadProductImages(array $images, Product $product)
    {
        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {

                $path = FileUploader::upload($image);

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                ]);
            }
        }
    }

    public function allProduct()
    {
        $products = Product::with(['singleImage', 'category'])->latest()->get();

        return view('pages.products.all-products', compact('products'));
    }

    public function createView()
    {
        $categories = Category::all();

        return view('pages.products.create', compact('categories'));
    }

    public function create(Request $request)
    {


        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'images' => 'required|array', // images must be an array
            'images.*' => 'image|mimes:jpeg,png,jpg', // each file must be an image
            'variations' => 'required|array',
            'variations.*.size' => 'required|string',
            'variations.*.price' => 'required|numeric',
        ]);


        try {

            $product = Product::create([

                'id' => Str::uuid(),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'meta_keywords' => $request->input('meta_keywords'),
                'price' => $request->input('price'),
                'quantity' => $request->input('quantity'),
                'is_active' => $request->has('draft') ? false : true,
                'category_id' => $request->input('category_id'),
            ]);

            foreach ($request->input('variations') as $variation) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'size' => $variation['size'],
                    'price' => $variation['price'],
                ]);
            }

            $this->uploadProductImages($request->file('images'), $product);


            return redirect()->route('products.all')->with('success', 'Product created successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to create product. Please try again.');
        }
    }

    public function updateView(Product $product)
    {

        $categories = Category::all();

        return view('pages.products.update', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'remove_images' => 'nullable|array', // images must be an array
            'images' => 'nullable|array', // images must be an array
            'images.*' => 'image|mimes:jpeg,png,jpg', // each file must be an image
            'variations' => 'required|array',
            'variations.*.id' => 'nullable|numeric',
            'variations.*.size' => 'required|string',
            'variations.*.price' => 'required|numeric',
        ]);


        try {

            $remove_images = $request->input('remove_images');

            $images = $request->file('images');

            $variations = $request->input('variations');

            $remove_variations = array_filter(
                explode(',', $request->input('remove_variations'))
            );


            $product->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'meta_keywords' => $request->input('meta_keywords'),
                'price' => $request->input('price'),
                'quantity' => $request->input('quantity'),
                'category_id' => $request->input('category_id'),
                'is_active' => $request->has('draft') ? false : true,
            ]);


            foreach ($variations as $variation) {
                if (isset($variation['id'])) {
                    ProductVariation::where('id', $variation['id'])->update([
                        'size' => $variation['size'],
                        'price' => $variation['price'],
                    ]);
                } else {
                    ProductVariation::create([
                        'product_id' => $product->id,
                        'size' => $variation['size'],
                        'price' => $variation['price'],
                    ]);
                }
            }

            if ($remove_variations) {
                ProductVariation::destroy($remove_variations);
            }

            if ($images) {

                $this->uploadProductImages($images, $product);
            }

            if ($remove_images) {
                ProductImage::destroy($remove_images);
            }

            return redirect()->route('products.all')->with('success', 'Product updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to update product. Please try again.');
        }
    }



    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.all')->with('success', 'Product deleted successfully.');
    }
}
