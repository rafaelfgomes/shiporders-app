<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contact class
 * 
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @ORM\Table(name="contacts")
 * 
 */
class Contact
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
    private $number;

    /**
     * Many Contacts have Many Persons
     * @ORM\ManyToMany(targetEntity="Person", mappedBy="contacts")
     */
    private $persons;

    public function __construct()
    {
        $this->persons = new ArrayCollection();
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
     * Get the name of person
     *
     * @return string
     */
    public function getNumber() : ?string
    {
        return $this->number;
    }

    /**
     * Set the name of person
     *
     * @param string $name
     * @return void
     */
    public function setNumber(string $number) : void
    {
        $this->number = $number;
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

    public function getPersons() : ArrayCollection
    {
        return $this->persons;
    }

    public function setPersons(Person $person) : void
    {
        $this->persons[] = $person;
    }
}