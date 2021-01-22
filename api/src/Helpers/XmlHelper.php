<?php

namespace App\Helpers;

class XmlHelper
{
    /**
     * Format people xml to array
     *
     * @param object $data
     * @return array
     */
    public static function formatPeopleXmlToArray(object $data) : array
    {
        $arrPeople  = [];

        $json = json_encode($data);
        $arr = json_decode($json);

        foreach ($arr->person as $person) {
            $arrPeople[] = [
                'id' => $person->personid,
                'name' => $person->personname,
                'contacts' => (is_array($person->phones->phone)) ? $person->phones->phone : [ $person->phones->phone ]
            ];
        }

        return $arrPeople;
    }

    /**
     * Format shiporders xml to array
     *
     * @param object $data
     * @return array
     */
    public static function formatShipordersXmlToArray(object $data) : array
    {
        $arrShiporders  = [];
        $count = 0;

        $json = json_encode($data);
        $arr = json_decode($json);

        foreach ($arr->shiporder as $order) {
            $arrShiporders[] = [
                'id' => $order->orderid,
                'person_id' => $order->orderperson,
                'address' => [
                    'location' => $order->shipto->address,
                    'city' => $order->shipto->city,
                    'country' => $order->shipto->country
                ]
            ];

            if (is_array($order->items->item)) {
                foreach ($order->items->item as $item) {
                    $arrShiporders[$count]['items'][] = [
                        'title' => $item->title,
                        'note' => $item->note,
                        'quantity' => $item->quantity,
                        'price' => $item->price
                    ];
                    
                }
            } else {
                $arrShiporders[$count]['items'][] = [
                    'title' => $order->items->item->title,
                    'note' => $order->items->item->note,
                    'quantity' => $order->items->item->quantity,
                    'price' => $order->items->item->price
                ];
            }

            $count++;
        }

        return $arrShiporders;
    }
}