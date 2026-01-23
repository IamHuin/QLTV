<?php

namespace App\Reposiroty\Eloquent;

use App\Models\Group;
use App\Models\UserGroup;
use App\Reposiroty\Contract\GroupRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class GroupRepository implements GroupRepositoryInterface
{

    public function getGroupById($id)
    {
        // TODO: Implement getGroupById() method.
        $group = Group::find($id);
        if (isset($group)) {
            return $group;
        }
        return null;
    }

    public function showAllGroups()
    {
        // TODO: Implement showAllGroups() method.
        $user = JWTAuth::user();
        if ($user['role_id'] == 1) {
            return Group::paginate(10);
        } else {
            $user_group = UserGroup::where(['user_id' => $user['id']])->pluck('group_id');
            return Group::whereIn('id', $user_group)->paginate(10);
        }
    }

    public function deleteGroup($id)
    {
        // TODO: Implement deleteGroup() method.
        UserGroup::where('group_id', $id)->delete();
        $group = Group::find($id);
        if (isset($group)) {
            return $group->delete();
        }
        return false;
    }

    public function updateGroup($id, array $data)
    {
        // TODO: Implement updateGroup() method.
        $group = Group::where('id', $id);
        if (isset($group)) {
            $group->update($data);
            return $group;
        }
        return null;
    }

    public function createGroup(array $data)
    {
        // TODO: Implement createGroup() method.
        $group = Group::create($data);
        return $group;
    }

    public function joinGroup($groupId, $userId)
    {
        // TODO: Implement joinGroup() method.
        //Lấy id group và user hiện tại
        $group = $this->getGroupById($groupId);
        //Kiểm tra user đã join nhóm chưa
        $exists = UserGroup::where([
            'user_id' => $userId,
            'group_id' => $groupId
        ])->exists();
        if (!$exists) {//Nếu chưa gia nhập
            $user_group = UserGroup::create([
                'user_id' => $userId,
                'group_id' => $groupId
            ]);
            return $user_group;
        }
        return null;
    }
}
