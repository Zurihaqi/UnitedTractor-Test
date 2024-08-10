<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ProductService
{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllProducts()
    {
        try {
            return $this->repository->all();
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to fetch products',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductById($id)
    {
        try {
            $product = $this->repository->find($id);

            if (!$product) {
                throw new ModelNotFoundException("Product with id $id not found");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Product retrieved successfully',
                'data' => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function createProduct(array $data)
    {
        try {
            if (isset($data['image'])) {
                $data['image'] = $this->uploadImage($data['image']);
            }
            $product = $this->repository->create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProduct($id, array $data)
    {
        try {
            if (isset($data['image'])) {
                $data['image'] = $this->uploadImage($data['image']);
            }
            $product = $this->repository->update($id, $data);

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'data' => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = $this->repository->delete($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully',
                'data' => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    protected function uploadImage($image)
    {
        try {
            $path = $image->store('images/products', 'public');
            return $path;
        } catch (Exception $e) {
            throw new Exception("Failed to upload image: " . $e->getMessage());
        }
    }
}
