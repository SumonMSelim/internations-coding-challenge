<?php

namespace App\Service;

use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserGroup;
use App\Repository\UserGroupRepository;

class UserGroupService
{
    private $userGroupRepository;

    public function __construct(UserGroupRepository $userGroupRepository)
    {
        $this->userGroupRepository = $userGroupRepository;
    }

    public function checkIfAlreadyAssigned(int $user_id, int $group_id)
    {
        return $this->userGroupRepository->checkIfAssigned($user_id, $group_id);
    }

    public function assign(User $user, Group $group): UserGroup
    {
        return $this->userGroupRepository->assign($user, $group);
    }

    public function remove(UserGroup $user_group): bool
    {
        return $this->userGroupRepository->remove($user_group);
    }
}
