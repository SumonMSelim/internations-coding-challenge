<?php

namespace App\Controller\Api\V1;

use App\Entity\Group;
use App\Service\GroupService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends BaseController
{
    private $groupService;

    public function __construct(GroupService $groupService)
    {
        parent::__construct();
        $this->groupService = $groupService;
    }

    /**
     * @Route("/api/v1/group", name="api_v1_group_create", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request): JsonResponse
    {
        $inputs = $this->getInputFromRequest($request);
        $validation = $this->validateInputs($inputs);

        if ($validation === true) {
            $group_exists = $this->groupService->checkIfGroupExists($inputs['name']);

            if ($group_exists !== null) {
                return $this->respondWithError('Group already exists.', [], 400);
            }

            // create group
            $group = $this->groupService->createGroup($inputs);

            if ($group instanceof Group) {
                $response = [
                    'id' => $group->getId(),
                    'group' => $group->getName(),
                    'created_at' => $group->getCreatedAt()->format('Y-m-d H:i:s'),
                ];

                return $this->respondWithSuccess('Group added', ['group' => $response]);
            }
        }

        return $validation;
    }

    /**
     * @Route("/api/v1/group/{id}", name="api_v1_group_delete", methods={"DELETE"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(int $id): JsonResponse
    {
        $group = $this->groupService->findGroupById($id);

        if ($group) {
            $this->groupService->deleteGroup($group);

            return $this->respondWithSuccess('Group removed.');
        }

        return $this->respondWithError('Group not found.', [], 404);
    }

    /**
     * @param array $inputs
     * @return bool|\Symfony\Component\HttpFoundation\JsonResponse
     */
    private function validateInputs(array $inputs)
    {
        $name = $inputs['name'];

        if (empty($name)) {
            return $this->respondWithError('Name field is required.');
        }

        if (strlen($name) < 4) {
            return $this->respondWithError('Name must have at least 4 chars.');
        }

        return true;
    }
}
