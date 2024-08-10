<?php

namespace App\Repositories;

use App\Models\CategoryProduct;

class CategoryProductRepository implements CategoryProductRepositoryInterface
{
    protected $model;

    public function __construct(CategoryProduct $categoryProduct)
    {
        $this->model = $categoryProduct;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $categoryProduct = $this->model->find($id);

        if (!$categoryProduct) {
            return null;
        }

        $categoryProduct->update($attributes);
        return $categoryProduct;
    }


    public function delete($id)
    {
        $categoryProduct = $this->model->find($id);

        if (!$categoryProduct) {
            return null;
        }

        $categoryProduct->delete();
        return $categoryProduct;
    }
}
