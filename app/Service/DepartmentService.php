<?php

namespace App\Service;

use App\Repository\Contract\DepartmentRepositoryInterface;

class DepartmentService
{
    protected $departRepo;

    public function __construct(DepartmentRepositoryInterface $departmentRepo)
    {
        $this->departRepo = $departmentRepo;
    }

    public function create($data)
    {
        return $this->departRepo->create([
            'name' => $data
        ]);
    }

    public function update($data, $id)
    {
        return $this->departRepo->update([
            'name' => $data
        ], $id);
    }

    public function delete($id)
    {
        return $this->departRepo->delete($id);
    }

    public function getAll($data)
    {
        return $this->departRepo->getAll($data);
    }

    public function search($data, $search)
    {
        return $this->departRepo->search($data, $search);
    }

    public function getById($id)
    {
        return $this->departRepo->getById($id);
    }

}
