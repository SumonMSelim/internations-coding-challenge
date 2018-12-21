<?php

namespace App\Controller\Api\V1;

use App\Service\GroupService;
use App\Service\UserGroupService;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserGroupController extends BaseController
{
    private $userGroupService;

    private $userService;

    private $groupService;

    public function __construct(UserGroupService $userGroupService, UserService $userService, GroupService $groupService)
    {
        parent::__construct();
        $this->userGroupService = $userGroupService;
        $this->userService = $userService;
        $this->groupService = $groupService;
    }

    /**
     * @Route("/api/v1/user/group/assign", name="api_v1_user_group_assign", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|null
     */
    public function assign(Request $request): ?JsonResponse
    {
        $inputs = $this->getInputFromRequest($request);
        $validation = $this->validateInputs($inputs);

        if ($validation === true) {
            $user_id = $inputs['user_id'];
            $group_id = $inputs['group_id'];

            $user = $this->userService->findUserById($user_id);
            if ($user === null) {
                return $this->respondWithError('User not found.', [], 404);
            }

            $group = $this->groupService->findGroupById($group_id);
            if ($group === null) {
                return $this->respondWithError('Group not found.', [], 404);
            }

            $already_assigned = $this->userGroupService->checkIfAlreadyAssigned($user_id, $group_id);

            if ($already_assigned !== null) {
                return $this->respondWithError('User already assigned to group.', [], 400);
            }

            // assign user to group
            $this->userGroupService->assign($user, $group);

            return $this->respondWithSuccess('User assigned to group.', [], 201);
        }

        return $validation;
    }

    /**
     * @Route("/api/v1/user/group/remove", name="api_v1_user_group_remove", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|null
     */
    public function remove(Request $request): ?JsonResponse
    {
        $inputs = $this->getInputFromRequest($request);
        $validation = $this->validateInputs($inputs);

        if ($validation === true) {
            $user_id = $inputs['user_id'];
            $group_id = $inputs['group_id'];

            if ($this->userService->findUserById($user_id) === null) {
                return $this->respondWithError('User not found.', [], 404);
            }

            if ($this->groupService->findGroupById($group_id) === null) {
                return $this->respondWithError('Group not found.', [], 404);
            }

            $already_assigned = $this->userGroupService->checkIfAlreadyAssigned($user_id, $group_id);

            if ($already_assigned !== null) {
                // remove user from group
                $this->userGroupService->remove($already_assigned);

                return $this->respondWithSuccess('User removed from group.', [], 200);
            }

            return $this->respondWithError('User is not assigned to this group.', [], 400);
        }
    }

    private function validateInputs($inputs)
    {
        $user_id = (int) $inputs['user_id'];
        $group_id = (int) $inputs['group_id'];

        if (empty($user_id)) {
            return $this->respondWithError('User ID field is required.');
        }

        if (empty($group_id)) {
            return $this->respondWithError('Group ID field is required.');
        }

        if (! is_int($user_id)) {
            return $this->respondWithError('User ID must be an integer.');
        }

        if (! is_int($group_id)) {
            return $this->respondWithError('Group ID must be an integer.');
        }

        return true;
    }
}
