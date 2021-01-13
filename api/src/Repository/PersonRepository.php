<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Entity\Person;
use App\Interfaces\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class PersonRepository implements RepositoryInterface
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

    public function store(array $data) : ?array
    {
        $person = new Person();
        $person->setName($data['name']);

        foreach ($data['contacts'] as $personContact) {
            $contact = new Contact();
            $contact->setNumber($personContact);
            $this->entityManager->persist($contact);
            $person->setContacts($contact);
        }

        $this->entityManager->persist($person);
        $this->entityManager->flush();
        
        return $person->getFields();
    }
    
}