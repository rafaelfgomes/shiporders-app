<?php

namespace App\Repository;

use App\Entity\Address;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Person;
use App\Interfaces\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class OrderRepository implements RepositoryInterface
{
    /**
     * Entity manager
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function store(array $data): Order
    {
        $order = new Order();

        $person = $this->entityManager->find(Person::class, $data['person_id']);

        $order->setPersonId($person->getId());

        $address = new Address();

        $address->setLocation($data['address']['location']);
        $address->setCity($data['address']['city']);
        $address->setCountry($data['address']['country']);

        $this->entityManager->persist($address);

        $order->setAddress($address);

        foreach ($data['items'] as $orderItem) {
            $item = new Item();
            $item->setTitle($orderItem['title']);
            $item->setNote($orderItem['note']);
            $item->setQuantity($orderItem['quantity']);
            $item->setPrice($orderItem['price']);
            $this->entityManager->persist($item);
            $order->setItems($item);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }
}