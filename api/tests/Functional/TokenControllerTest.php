<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TokenControllerTest extends WebTestCase
{
    public function testGetToken()
    {
        $client = static::createClient();

        $client->request('GET', '/api/token/get');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}