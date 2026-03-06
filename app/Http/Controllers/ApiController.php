<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'externalId'  => 'required|string',
            'email' => 'required|email',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ]);
        }

        try {

            $data = $validator->validated();

            $user = User::where('email', $data['email'])->first();

            if (!$user) {
                $user = User::create([
                    'id' => $data['externalId'],
                    'first_name' => $data['firstName'],
                    'last_name' => $data['lastName'],
                    'email' => $data['email'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('default123@@'),
                ]);
            }

            return response()->json([
                'message' => 'User created successfully',
                'data' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'User creation failed',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getCategories(Request $request)
    {
        $categories = Category::latest()->get();

        return response()->json([
            'message' => 'Categories fetched successfully',
            'data' => $categories,
        ]);
    }

    public function getProducts(Request $request)
    {
        $products = Product::where('is_active', true)->with('singleImage:product_id,path', 'category:id,name')->latest()->get();

        return response()->json([
            'message' => 'Products fetched successfully',
            'data' => $products,
        ]);
    }

    public function getProductById(Request $request, $productId)
    {
        $product = Product::where('id', $productId)->where('is_active', true)->with('multipleImages:product_id,path', 'category:id,name' , 'variations:id,product_id,shape_id,size,price' ,'variations.shape:id,name,slug')->first();

        if (!$product) {
            return response()->json([
                    'message' => 'Product not found',
                    'data' => null,
                ]);
        }

        return response()->json([
            'message' => 'Product fetched successfully',
            'data' => $product,
        ]);
    }

    public function getProductCollections(Request $request)
    {
        $productCollections = ProductCollection::latest()->get();

        return response()->json([
            'message' => 'Product collections fetched successfully',
            'data' => $productCollections,
        ]);
    }
}
