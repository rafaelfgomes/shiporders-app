<?php

namespace App\Interfaces;

use App\Entity\Person;

interface RepositoryInterface
{
    public function store(array $data) : object;
}