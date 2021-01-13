<?php

namespace App\Repository;

use App\Entity\Item;
use App\Interfaces\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ItemRepository implements RepositoryInterface
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

    public function store(array $data): ?array
    {
        $item = new Item();

        $item->setTitle($data['title']);
        $item->setNote($data['note']);
        $item->setQuantity($data['quantity']);
        $item->setPrice($data['price']);

        $this->entityManager->persist($item);

        return $item->getFields();
    }
}