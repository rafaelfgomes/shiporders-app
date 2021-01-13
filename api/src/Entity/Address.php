<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address class
 * 
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 * @ORM\Table(name="addresses")
 * 
 */
class Address
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
    private $location;

    /**
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     */
    private $country;

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
     * Get address name
     *
     * @return string
     */
    public function getLocation() : ?string
    {
        return $this->location;
    }

    /**
     * Set address name
     *
     * @param string $name
     * @return void
     */
    public function setLocation(string $location) : void
    {
        $this->location = $location;
    }

    /**
     * Get address city
     *
     * @return string
     */
    public function getCity() : ?string
    {
        return $this->city;
    }

    /**
     * Set address city
     *
     * @param string $city
     * @return void
     */
    public function setCity(string $city) : void
    {
        $this->city = $city;
    }

    /**
     * Get address country
     *
     * @return string
     */
    public function getCountry() : ?string
    {
        return $this->country;
    }

    /**
     * Set address country
     *
     * @param string $country
     * @return void
     */
    public function setCountry(string $country) : void
    {
        $this->country = $country;
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
}