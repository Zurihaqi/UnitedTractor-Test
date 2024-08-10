<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllProducts()
    {
        return $this->repository->all();
    }

    public function getProductById($id)
    {
        return $this->repository->find($id);
    }

    public function createProduct(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = $this->repository->find($id);
        if (!$product) {
            return null;
        }

        return $this->repository->update($id, $data);
    }

    public function deleteProduct($id)
    {

        $product = $this->repository->find($id);
        if (!$product) {
            return null;
        }

        return $this->repository->delete($id);
    }
}
