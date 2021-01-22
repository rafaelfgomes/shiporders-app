<?php

namespace App\Tests\Entity;

use App\Entity\Address;
use App\Entity\Item;
use App\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    public function testPersonIdField()
    {
        $personId = 1;
        
        $order = new Order();
        $order->setPersonId($personId);

        $this->assertEquals($personId, $order->getPersonId());
    }

    public function testAddressIdField()
    {
        $addressId = 1;
        
        $order = new Order();
        $order->setAddressId($addressId);

        $this->assertEquals($addressId, $order->getAddressId());
    }

    public function testAddress()
    {
        $location = "6th Avenue Heartache";
        $city = "Michigan";
        $country = "United States";

        $address = new Address();
        $order = new Order();

        $address->setLocation($location);
        $address->setCity($city);
        $address->setCountry($country);

        $order->setAddress($address);

        $this->assertEquals($address, $order->getAddress());
    }

    public function testItems()
    {
        $title = 'Item 1';
        $note = 'Test';
        $quantity = 10;
        $price = 50.00;

        $item = new Item();
        $order = new Order();

        $item->setTitle($title);
        $item->setNote($note);
        $item->setQuantity($quantity);
        $item->setPrice($price);

        $order->setItems($item);

        $this->assertEquals(new ArrayCollection([ $item ]), $order->getItems());
    }

}