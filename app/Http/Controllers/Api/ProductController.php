<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $products = $this->productService->getAllProducts();
            return response()->json([
                "status" => "success",
                "message" => "Products retrieved successfully",
                "data" => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Server error",
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->getProductById($id);
            if (!$product) {
                return response()->json([
                    "status" => "error",
                    "message" => "Product not found",
                    "data" => null
                ], 404);
            }
            return response()->json([
                "status" => "success",
                "message" => "Product retrieved successfully",
                "data" => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Server error",
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_category_id' => 'required|exists:category_products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Bad request",
                "data" => $validator->errors()
            ], 400);
        }

        try {
            $product = $this->productService->createProduct($request->all());
            return response()->json([
                "status" => "success",
                "message" => "Product created successfully",
                "data" => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Server error",
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_category_id' => 'nullable|exists:category_products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['name', 'price', 'product_category_id']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('images/products', $filename, 'public');
            $data['image'] = $path;
        }

        $updatedProduct = $this->productService->updateProduct($id, $data);

        if (!$updatedProduct) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $updatedProduct
        ], 200);
    }

    public function destroy($id)
    {
        try {
            $product = $this->productService->deleteProduct($id);
            if (!$product) {
                return response()->json([
                    "status" => "error",
                    "message" => "Product not found",
                    "data" => null
                ], 404);
            }
            return response()->json([
                "status" => "success",
                "message" => "Product deleted successfully",
                "data" => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Server error",
                "data" => $e->getMessage()
            ], 500);
        }
    }
}
