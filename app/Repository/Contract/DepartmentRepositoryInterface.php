<?php

namespace App\Repository\Contract;

use App\Models\Department;

interface DepartmentRepositoryInterface
{
    public function create(array $data);

    public function getById($id);

    public function getAll($data);

    public function update(array $data, $id);

    public function delete($id);

    public function search($data, $search);
}
