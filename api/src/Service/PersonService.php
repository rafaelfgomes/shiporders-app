<?php

namespace App\Service;

use App\Entity\Person;
use App\Repository\PersonRepository;

class PersonService
{
    /**
     * Person repository
     *
     * @var PersonRepository
     */
    private $personRepository;
    
    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function store(array $data) : Person
    {
        return $this->personRepository->store($data);
    }
}