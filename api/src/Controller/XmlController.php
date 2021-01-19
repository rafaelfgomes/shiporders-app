<?php

namespace App\Controller;

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
     * @Route("/api/xml/get-content", methods={"GET"}, name="get_xml_content")
     */
    public function getXml(Request $request, string $extension = '.xml') : JsonResponse
    {
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
