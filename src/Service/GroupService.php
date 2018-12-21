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
}
