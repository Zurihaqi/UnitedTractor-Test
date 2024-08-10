<?php

namespace App\Services;

use App\Repositories\CategoryProductRepository;

class CategoryProductService
{
    protected $repository;

    public function __construct(CategoryProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllCategoryProducts()
    {
        return $this->repository->all();
    }

    public function getCategoryProductById($id)
    {
        return $this->repository->find($id);
    }

    public function createCategoryProduct(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateCategoryProduct($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteCategoryProduct($id)
    {
        return $this->repository->delete($id);
    }
}
