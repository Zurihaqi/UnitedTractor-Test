<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryProductController extends Controller
{
    protected $service;

    public function __construct(CategoryProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $categoryProducts = $this->service->getAllCategoryProducts();
            return response()->json([
                "status" => "success",
                "message" => "Category products retrieved successfully",
                "data" => $categoryProducts
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
            $categoryProduct = $this->service->getCategoryProductById($id);
            if (!$categoryProduct) {
                return response()->json([
                    "status" => "error",
                    "message" => "Category product not found",
                    "data" => null
                ], 404);
            }
            return response()->json([
                "status" => "success",
                "message" => "Category product retrieved successfully",
                "data" => $categoryProduct
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Bad request",
                "data" => $validator->errors()
            ], 400);
        }

        try {
            $categoryProduct = $this->service->createCategoryProduct($request->all());
            return response()->json([
                "status" => "success",
                "message" => "Category product created successfully",
                "data" => $categoryProduct
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
            'name' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Bad request",
                "data" => $validator->errors()
            ], 400);
        }

        try {
            $categoryProduct = $this->service->updateCategoryProduct($id, $request->all());
            if (!$categoryProduct) {
                return response()->json([
                    "status" => "error",
                    "message" => "Category product not found",
                    "data" => null
                ], 404);
            }
            return response()->json([
                "status" => "success",
                "message" => "Category product updated successfully",
                "data" => $categoryProduct
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Server error",
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $categoryProduct = $this->service->deleteCategoryProduct($id);
            if (!$categoryProduct) {
                return response()->json([
                    "status" => "error",
                    "message" => "Category product not found",
                    "data" => null
                ], 404);
            }
            return response()->json([
                "status" => "success",
                "message" => "Category product deleted successfully",
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
