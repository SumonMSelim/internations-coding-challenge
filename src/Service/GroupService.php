<?php

namespace App\Service;

use App\Entity\Group;
use App\Repository\GroupRepository;

class GroupService
{
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function checkIfGroupExists(string $name)
    {
        return $this->groupRepository->findByName($name);
    }

    public function createGroup(array $inputs): Group
    {
        return $this->groupRepository->create($inputs);
    }

    public function findGroupById(int $id)
    {
        return $this->groupRepository->findById($id);
    }

    public function deleteGroup(Group $group): bool
    {
        return $this->groupRepository->delete($group);
    }

    public function checkIfGroupIsEmpty(int $id): bool
    {
        return $this->groupRepository->getUsersCountByGroupId($id);
    }
}
