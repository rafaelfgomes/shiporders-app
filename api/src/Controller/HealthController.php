<?php

namespace App\Controller;

use App\Traits\ApiResponser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class for api health check
 */
class HealthController extends AbstractController
{
    use ApiResponser;

    /**
     * @Route("/api/health-check", name="health_check")
     */
    public function index() : JsonResponse
    {
        $data = [
            'health_check' => 'Ok'
        ];

        return $this->successResponse($data);
    }
}
