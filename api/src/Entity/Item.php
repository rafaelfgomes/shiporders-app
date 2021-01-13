<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Item class
 * 
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 * @ORM\Table(name="items")
 * 
 */
class Item
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $note;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $price;

    /**
     * Many Items have Many Orders
     * @ORM\ManyToMany(targetEntity="Order", mappedBy="items")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Get item title
     *
     * @return string|null
     */
    public function getTitle() : ?string
    {
        return $this->title;
    }

    /**
     * Set item title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    /**
     * Get item note
     *
     * @return string|null
     */
    public function getNote() : ?string
    {
        return $this->note;
    }

    /**
     * Set item note
     *
     * @param string $note
     * @return void
     */
    public function setNote(string $note) : void
    {
        $this->note = $note;
    }

    /**
     * Get item quantity
     *
     * @return integer|null
     */
    public function getQuantity() : ?int
    {
        return $this->quantity;
    }

    /**
     * Set item quantity
     *
     * @param integer $quantity
     * @return void
     */
    public function setQuantity(int $quantity) : void
    {
        $this->quantity = $quantity;
    }

    /**
     * Get item price
     *
     * @return float|null
     */
    public function getPrice() : ?float
    {
        return $this->price;
    }

    /**
     * Set item price
     *
     * @param float $price
     * @return void
     */
    public function setPrice(float $price) : void
    {
        $this->price = $price;
    }

    /**
     * Get all fields from Entity
     *
     * @return array
     */
    public function getFields() : array
    {
        return get_object_vars($this);
    }

    public function getOrders() : ArrayCollection
    {
        return $this->orders;
    }

    public function setOrders(Order $order) : void
    {
        $this->orders[] = $order;
    }
}