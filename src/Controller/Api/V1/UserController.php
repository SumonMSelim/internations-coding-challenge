<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends BaseController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * @Route("/api/v1/user", name="api_v1_user_create", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $inputs = $this->getInputFromRequest($request);
        $validation = $this->validateInputs($inputs);

        if ($validation === true) {
            $user_exists = $this->userService->checkIfUserExists($inputs['username']);

            if ($user_exists !== null) {
                return $this->respondWithError('User already exists.', [], 400);
            }

            // create user
            $user = $this->userService->createUser($inputs);

            if ($user instanceof User) {
                $response = [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'roles' => $user->getRoles(),
                ];

                return $this->respondWithSuccess('User added', ['user' => $response]);
            }
        }

        return $validation;
    }

    /**
     * @param array $inputs
     * @return bool|\Symfony\Component\HttpFoundation\JsonResponse
     */
    private function validateInputs(array $inputs)
    {
        $username = $inputs['username'];
        $password = $inputs['password'];

        if (empty($username)) {
            return $this->respondWithError('Username field is required.');
        }

        if (empty($password)) {
            return $this->respondWithError('Password field is required.');
        }

        if (preg_match('/^\w{4,}$/', $username) === 0) {
            return $this->respondWithError('Username can only contain alphanumeric, underscore and must have at least 4 chars.');
        }

        if (strlen($password) < 6) {
            return $this->respondWithError('Password must have at least 6 chars.');
        }

        return true;
    }
}
