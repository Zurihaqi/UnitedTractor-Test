<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
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
        $product = $this->model->find($id);

        if (!$product) {
            return null;
        }

        $product->update($attributes);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->model->find($id);

        if (!$product) {
            return null;
        }

        $product->delete();
        return $product;
    }
}
