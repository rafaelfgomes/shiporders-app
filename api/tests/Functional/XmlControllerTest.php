<?php

namespace App\Tests\Functional;

use App\Helpers\Token;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class XmlControllerTest extends WebTestCase
{
    public function testGetXmlPeople()
    {
        $encryptedHash = $this->generateToken();
        $url = '/api/xml/get-content?file-name=people';
        $client = static::createClient([], [ 'HTTP_Authorization' => $encryptedHash ]);

        $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetXmlShiporders()
    {
        $encryptedHash = $this->generateToken();
        $url = '/api/xml/get-content?file-name=shiporders';
        $client = static::createClient([], [ 'HTTP_Authorization' => $encryptedHash ]);

        $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    private function generateToken() : string
    {
        $token = new Token();
        $apiToken = $_ENV['API_TOKEN'];
        $hash = $token->encrypt($apiToken);

        return $hash;
    }
}