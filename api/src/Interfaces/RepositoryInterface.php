<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function store(array $data) : ?array;
}