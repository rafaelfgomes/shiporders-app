<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;

class OrderService
{
    /**
     * Order Repository
     *
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function store(array $data) : Order
    {
        return $this->orderRepository->store($data);
    }
}