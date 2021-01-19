<?php

namespace App\Controller;

use App\Service\UploadService;
use App\Traits\ApiResponser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends AbstractController
{

    use ApiResponser;

    /**
     * Upload service
     *
     * @var UploadService
     */
    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * @Route("/api/upload", methods={"POST"}, name="upload_files")
     */
    public function uploadFiles(Request $request) : JsonResponse
    {
        try {
            $result = $this->uploadService->uploadFiles($request);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->successResponse([ 'data' => $result ]);
    }
}