<?php

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    private $response;

    public function __construct()
    {
        $this->response = [];
    }

    protected function respondWithSuccess($message = '', $data = [], $code = 200): JsonResponse
    {
        $this->response = ['success' => true];

        return $this->json($this->prepareResponse($message, $data), $code);
    }

    protected function respondWithError($message = '', $data = [], $code = 400): JsonResponse
    {
        $this->response = ['success' => false];

        return $this->json($this->prepareResponse($message, $data), $code);
    }

    protected function getInputFromRequest(Request $request)
    {
        if (! empty($request->getContent())) {
            return json_decode($request->getContent(), true);
        }

        return $request->request->all();
    }

    private function prepareResponse($message = '', $data = []): array
    {
        if (! empty($message)) {
            $this->response['message'] = $message;
        }

        if (! empty($data)) {
            $this->response['data'] = $data;
        }

        return $this->response;
    }
}
