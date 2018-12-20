<?php

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="root")
     * @Route("/api", name="api_root")
     * @Route("/api/v1", name="api_v1_root")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'success' => true,
            'message' => 'Welcome to InterNations User Management System API!',
        ]);
    }
}
