<?php

namespace App\Tests\Entity;

use App\Entity\Contact;
use App\Entity\Person;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

class PersonTest extends TestCase {

    public function testNameField()
    {
        $name = 'Test name';
        
        $person = new Person();
        $person->setName($name);

        $this->assertEquals($name, $person->getName());
    }

    public function testContacts()
    {
        $person = new Person();
        $contact = new Contact();

        $contact->setNumber('13988447788');

        $person->setContacts($contact);

        $this->assertEquals(new ArrayCollection([$contact]), $person->getContacts());
    }

}
