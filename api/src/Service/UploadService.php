<?php

namespace App\Service;

use App\Helpers\XmlHelper;
use App\Traits\ApiResponser;
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

    public function uploadFiles(Request $request) : bool
    {
        $peopleXml = simplexml_load_file($request->files->get('people'));
        $shipordersXml = simplexml_load_file($request->files->get('shiporders'));

        if (false === $peopleXml || false === $shipordersXml) {
            return false;
        }

        $arrPeople = XmlHelper::formatPeopleXmlToArray($peopleXml);

        if (!$arrPeople) {
            return false;
        }

        foreach ($arrPeople as $person) {
            $this->personService->store($person);
        }

        $arrShiporders = XmlHelper::formatShipordersXmlToArray($shipordersXml);

        if (!$arrShiporders) {
            return false;
        }

        foreach ($arrShiporders as $order) {
            $this->orderService->store($order);
        }

        return true;
    }
}