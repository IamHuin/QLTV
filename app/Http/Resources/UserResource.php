<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = User::roleResole($this->role_id);
        return [
            'id' => $this->id,
            'role' => $role,
            'username' => $this->username,
            'email' => $this->email,
            'delete_at' => $this->delete_at
        ];
    }
}
