<?php

namespace App\Repository\Contract;

interface GroupRepositoryInterface
{
    public function getGroupById($id);

    public function showAllGroups();

    public function deleteGroup($id);

    public function updateGroup($id, array $data);

    public function createGroup(array $data);

    public function joinGroup($groupId, $userId);
}
