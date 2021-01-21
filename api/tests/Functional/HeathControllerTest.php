<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HealthControllerTest extends WebTestCase
{
    public function testHealthCheck()
    {
        $client = static::createClient();

        $client->request('GET', '/api/health-check');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}