<?php

namespace App\Service;

use App\Helpers\XmlHelper;
use App\Traits\ApiResponser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadService
{

    use ApiResponser;

    /**
     * person service
     *
     * @var PersonService
     */
    private $personService;

    /**
     * Shiporder service
     *
     * @var OrderService
     */
    private $orderService;

    public function __construct(PersonService $personService, OrderService $orderService)
    {
        $this->personService = $personService;
        $this->orderService = $orderService;
    }

    public function uploadFiles(Request $request) : array
    {

        $result = [];

        $peopleXml = simplexml_load_file($request->files->get('people'));
        $shipordersXml = simplexml_load_file($request->files->get('shiporders'));
        
        if (false === $peopleXml || false === $shipordersXml) {
            return $this->errorResponse("Erro ao carregar o XML", Response::HTTP_BAD_REQUEST);
        }

        $arrPeople = XmlHelper::formatPeopleXmlToArray($peopleXml);
        foreach ($arrPeople as $person) {
            $result[] = [
                'people' => $this->personService->store($person)
            ];
        }

        $arrShiporders = XmlHelper::formatShipordersXmlToArray($shipordersXml);
        foreach ($arrShiporders as $order) {
            $result[] = [
                'shiporders' => $this->orderService->store($order)
            ];
        }

        return $result;
    }
}