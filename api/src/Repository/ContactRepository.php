<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Interfaces\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ContactRepository implements RepositoryInterface
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
    
    public function store(array $data) : Contact
    {
        $contact = new Contact();

        $contact->setNumber($data['number']);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $contact;
    }
}