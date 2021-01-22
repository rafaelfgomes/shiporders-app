<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Person class
 * 
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 * @ORM\Table(name="persons")
 * 
 */
class Person
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
    private $name;

    /**
     * Many Persons have Many Contacts
     * @ORM\ManyToMany(targetEntity="Contact", inversedBy="persons")
     * @ORM\JoinTable(name="person_contact")
     */
    private $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Get the name of person
     *
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * Set the name of person
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
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

    public function getContacts() : ArrayCollection
    {
        return $this->contacts;
    }

    public function setContacts(Contact $contact) : void
    {
        $contact->setPersons($this);
        $this->contacts[] = $contact;
    }
}