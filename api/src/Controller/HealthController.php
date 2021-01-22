<?php

namespace App\Controller;

use App\Traits\ApiResponser;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class for api health check
 */
class HealthController extends AbstractController
{
    use ApiResponser;

    /**
     * @SWG\Info(title="Health Controller", version="1.0")
     */

    /**
     * Health check for api
     * 
     * Test if api is working and up
     * 
     * @Route("/api/health-check", methods={"GET"}, name="health_check")
     * @SWG\Response(
     *   response=200,
     *   description="Ok"
     * )
     * 
     */
    public function index() : JsonResponse
    {
        $data = [
            'health_check' => 'Ok'
        ];

        return $this->successResponse($data);
    }
}
