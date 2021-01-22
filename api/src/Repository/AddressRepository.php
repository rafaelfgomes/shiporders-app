<?php

namespace App\Repository;

use App\Entity\Address;
use App\Interfaces\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class AddressRepository implements RepositoryInterface
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

    public function store(array $data): Address
    {
        $address = new Address();

        $address->setLocation($data['location']);
        $address->setCity($data['city']);
        $address->setCountry($data['country']);

        $this->entityManager->persist($address);
        $this->entityManager->flush();

        return $address;  
    }
}