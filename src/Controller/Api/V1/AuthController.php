<?php

namespace App\Controller\Api\V1;

use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends BaseController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * @Route("/api/v1/login", name="api_v1_login", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function authenticate(Request $request): JsonResponse
    {
        $inputs = $this->getInputFromRequest($request);
        $username = trim($inputs['username']);
        $password = trim($inputs['password']);

        $user = $this->userService->checkIfUserExists($username);

        if ($user === null) {
            return $this->respondWithError('User not found.', [], 404);
        }

        $authenticated = $this->userService->authenticateUser($user, $password);

        if ($authenticated === false) {
            return $this->respondWithError('Invalid credentials.', [], 400);
        }

        $token = $this->userService->generateToken($username);

        return $this->respondWithSuccess('User authenticated', ['token' => $token]);
    }
}
