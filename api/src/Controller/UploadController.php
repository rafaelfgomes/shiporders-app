<?php

namespace App\Controller;

use App\Helpers\Token;
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
     * Token for api auth
     *
     * @var Token
     */
    private $token;

    /**
     * Upload service
     *
     * @var UploadService
     */
    private $uploadService;

    public function __construct(UploadService $uploadService, Token $token)
    {
        $this->uploadService = $uploadService;
        $this->token = $token;
    }

    /**
     * @Route("/api/upload", methods={"POST"}, name="upload_files")
     */
    public function uploadFiles(Request $request) : JsonResponse
    {
        if (!$request->headers->has('Authorization')) {
            $message = 'Unauthorized';
            return $this->errorResponse($message, Response::HTTP_UNAUTHORIZED);
        }

        $tokenHeader = $request->headers->get('Authorization');
        $decryptedHash = $this->token->decrypt($tokenHeader);

        if (!($decryptedHash === $this->getParameter('api.token')))  {
            $message = 'Token mismatch';
            return $this->errorResponse($message, Response::HTTP_UNAUTHORIZED);
        }

        try {
            $result = $this->uploadService->uploadFiles($request);

            if (!$result) {
                $this->errorResponse('Error on XML upload', Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->successResponse([ 'message' => 'XML processado com sucesso!!!' ]);
    }
}