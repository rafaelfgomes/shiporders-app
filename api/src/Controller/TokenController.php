<?php

namespace App\Controller;

use App\Helpers\Token;
use App\Traits\ApiResponser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TokenController extends AbstractController
{

    use ApiResponser;

    private $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * @Route("/api/token/get", methods={"GET"}, name="get_token")
     */   
    public function getToken()
    {
        try {
            $apiToken = $this->token->encrypt($this->getParameter('api.token'));
            if (!isset($apiToken)) {
                $messsage = 'Error on auth token generation';
                return $this->errorResponse($messsage, Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->successResponse(['token' => $apiToken]);
    }
}