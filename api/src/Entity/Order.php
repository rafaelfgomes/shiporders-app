<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Order class
 * 
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="orders")
 * 
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="person_id")
     */
    private $personId;

    /**
     * @ORM\Column(type="integer", name="address_id")
     */
    private $addressId;

    /**
     * Many Order have Many Items
     * @ORM\ManyToMany(targetEntity="Item", inversedBy="orders")
     * @ORM\JoinTable(name="order_item")
     */
    private $items;

    /**
     * One Order has One Address.
     * @ORM\OneToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
    private $address;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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
     * Get person id
     *
     * @return integer
     */
    public function getPersonId() : ?int
    {
        return $this->personId;
    }

    /**
     * Set person id
     *
     * @param integer $personId
     * @return void
     */
    public function setPersonId(int $personId) : void
    {
        $this->personId = $personId;
    }

    /**
     * Get address id
     *
     * @return integer
     */
    public function getAddressId() : ?int
    {
        return $this->addressId;
    }

    /**
     * Set address id
     *
     * @param integer $addressId
     * @return void
     */
    public function serAddressId(int $addressId) : void
    {
        $this->addressId = $addressId;
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

    public function getItems() : ArrayCollection
    {
        return $this->items;
    }

    public function setItems(Item $item)
    {
        $item->setOrders($this);
        $this->items[] = $item;
    }

    public function getAddress() : Address
    {
        return $this->address;
    }

    public function setAddress(Address $address) : void
    {
        $this->address = $address;
    }
    
}