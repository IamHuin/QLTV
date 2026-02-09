<?php

namespace App\Http\Resources;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class URDResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::firstWhere('id', $this->user_id)->name;
        $role = Role::firstWhere('id', $this->role_id)->name;
        $department = Department::firstWhere('id', $this->department_id)->name;
        return [
            'user' => $user,
            'role' => $role,
            'department' => $department,
            'status' => $this->status
        ];
    }
}
