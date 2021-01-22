<?php

namespace App\Controller;

use App\Helpers\Token;
use App\Helpers\XmlHelper;
use App\Traits\ApiResponser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class for get xml information
 */
class XmlController extends AbstractController
{
    use ApiResponser;

    /**
     * Token for api auth
     *
     * @var Token
     */
    private $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * @Route("/api/xml/get-content", methods={"GET"}, name="get_xml_content")
     */
    public function getXml(Request $request, string $extension = '.xml') : JsonResponse
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

        $rootPath = $_SERVER['PWD'];
        $fileName = $request->query->get('file-name');

        if (preg_match("~\bpeople\b~", $fileName) || preg_match("~\bshiporders\b~", $fileName)) {
            try {
                $data = [];
                $xml = simplexml_load_file($rootPath . '/files/'. $fileName.$extension);
                $data = ('people' === $fileName) ? XmlHelper::formatPeopleXmlToArray($xml) : XmlHelper::formatShipordersXmlToArray($xml);
            } catch (\Exception $ex) {
                return $this->errorResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
            }
    
            return $this->successResponse($data);
        }

        return $this->errorResponse('File not found...' , Response::HTTP_BAD_REQUEST);
    }
}
