<?php

namespace App\Repositories;

interface CategoryProductRepositoryInterface
{

    public function all();
    public function find($id);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function delete($id);

}