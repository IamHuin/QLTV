<?php

namespace App\Service;

use App\Repository\Contract\GroupRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GroupService
{
    protected $groupRepo;

    public function __construct(GroupRepositoryInterface $groupRepo)
    {
        $this->groupRepo = $groupRepo;
    }

    public function createGroup($data)
    {
        $group = $this->groupRepo->createGroup([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
        return $group;
    }

    public function showAllGroups()
    {
        return $this->groupRepo->showAllGroups();
    }

    public function getGroup($id)
    {
        $group = $this->groupRepo->getGroupById($id);
        return $group;
    }

    public function updateGroup($id, $data)
    {
        $group = $this->groupRepo->updateGroup($id, [
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
        return $group;
    }

    public function deleteGroup($id)
    {
        $group = $this->groupRepo->deleteGroup($id);
        return $group;
    }

    public function joinGroup($groupId)
    {
        $user = Auth::user();
        $join = $this->groupRepo->joinGroup($groupId, $user['id']);
        return $join;
    }
}
