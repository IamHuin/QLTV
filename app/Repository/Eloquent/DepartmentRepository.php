<?php

namespace App\Repository\Eloquent;

use App\Models\Department;
use App\Models\UserRoleDepartment;
use App\Repository\Contract\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{

    public function create(array $data)
    {
        // TODO: Implement create() method.
        return Department::create([
            'name' => $data['name']
        ]);
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
        $department = Department::find($id);
        if (empty($department)) {
            return null;
        }
        return $department;
    }

    public function getAll($data)
    {
        // TODO: Implement getAll() method.
        $limit = $data['paginate']['limit'];
        $page = $data['paginate']['page'];
        $maxPage = $data['paginate']['maxPage'];
        if ($page > $maxPage) {
            return response()->json([
                'error' => 'maxPage',
            ], 400);
        }
        $show = Department::paginate($limit);
        return [
            'data' => $show,
            'paginate' => $show,
        ];
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
        $ex = $this->getById($id);
        if (empty($ex)) {
            return null;
        }
        return $ex->update([
            'name' => $data['name'],
        ]);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        $ex = $this->getById($id);
        if (empty($ex)) {
            return null;
        }
        UserRoleDepartment::where('department_id', $id)->delete();
        return $ex->delete();
    }

    public function search($data, $search)
    {
        // TODO: Implement search() method.
        $limit = $data['paginate']['limit'];
        $page = $data['paginate']['page'];
        $maxPage = $data['paginate']['maxPage'];
        if ($page > $maxPage) {
            return response()->json([
                'error' => 'maxPage',
            ], 400);
        }
        $show = Department::where('name', 'LIKE', '%' . $search . '%')->paginate($limit);
        return [
            'data' => $show,
            'paginate' => $show,
        ];
    }
}
