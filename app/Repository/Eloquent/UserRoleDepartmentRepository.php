<?php

namespace App\Repository\Eloquent;

use App\Models\Department;
use App\Models\Role;
use App\Models\UserRoleDepartment;
use App\Repository\Contract\UserRoleDepartmentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRoleDepartmentRepository implements UserRoleDepartmentRepositoryInterface
{

    public function createUserRoleDepartment($request)
    {
        // TODO: Implement createUserRoleDepartment() method.
        $user_id = $request->user_id;
        $role_id = $request->role_id;
        $department_id = $request->department_id;
        $listURD = UserRoleDepartment::where([
            'user_id' => $user_id,
            'status' => 'active',
        ]);
        $listRole = $listURD->pluck('role_id')->toArray();
        $exRole = in_array($role_id, $listRole);
        $listDepart = $listURD->where([
            'role_id' => $role_id,
        ])->pluck('department_id')->toArray();
        $exDepart = in_array($department_id, $listDepart);
        $urd = UserRoleDepartment::where([
            'user_id' => $user_id,
            'role_id' => $role_id,
            'department_id' => $department_id,
            'status' => 'inactive',
        ]);
        $exStatus = $urd->exists();
        if ($exRole) {
            if ($role_id == 2) {
                if (!$exDepart) {
                    if (!$exStatus) {
                        $listURD->update(['status' => 'inactive']);
                        return UserRoleDepartment::create([
                            'user_id' => $user_id,
                            'role_id' => $role_id,
                            'department_id' => $department_id,
                        ]);
                    }
                    $listURD->update(['status' => 'inactive']);
                    return $urd->update(['status' => 'active']);
                }
                return null;
            } elseif ($role_id == 3) {
                if ($exDepart) {
                    return null;
                }
                $listURD->create([
                    'user_id' => $user_id,
                    'role_id' => $role_id,
                    'department_id' => $department_id,
                ]);
            }
        }
        if ($role_id == 2) {
            if (!$exStatus) {
                return UserRoleDepartment::create([
                    'user_id' => $user_id,
                    'role_id' => $role_id,
                    'department_id' => $department_id,
                ]);
            }
            return $urd->update(['status' => 'active']);
        } elseif ($role_id == 3) {
            if ($exDepart) {
                return null;
            }
            return $listURD->create([
                'user_id' => $user_id,
                'role_id' => $role_id,
                'department_id' => $department_id,
            ]);
        }
        return null;
    }

    public function showUserRoleDepartment($data)
    {
        // TODO: Implement showUserRoleDepartment() method.
        $limit = $data['paginate']['limit'];
        $page = $data['paginate']['page'];
        $maxPage = $data['paginate']['maxPage'];

        if ($page > $maxPage) {
            return response()->json([
                'error' => 'maxPage',
            ], 400);
        }
        $user_id = Auth::user()->id;
        $role_id = UserRoleDepartment::where('user_id', $user_id)->pluck('role_id')->toArray();
        dd($role_id);
    }

    public function updateUserRoleDepartment($data)
    {
        // TODO: Implement updateUserRoleDepartment() method.
    }

    public function destroyUserRoleDepartment($data)
    {
        // TODO: Implement destroyUserRoleDepartment() method.
    }
}
