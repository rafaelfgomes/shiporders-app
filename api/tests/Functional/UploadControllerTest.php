<?php

namespace App\Tests\Functional;

use App\Helpers\Token;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadControllerTest extends WebTestCase
{
    public function testUploadFiles()
    {
        $encryptedHash = $this->generateToken();
        $url = '/api/upload';
        $client = static::createClient([], [ 'CONTENT_TYPE' => 'multipart/form-data', 'HTTP_Authorization' => $encryptedHash ]);
        $filesPath = $_SERVER['PWD'] . '/files';

        $people = new UploadedFile($filesPath . '/people.xml', 'people.xml', 'text/xml');
        $shiporders = new UploadedFile($filesPath . '/shiporders.xml', 'shiporders.xml', 'text/xml');

        $client->request('POST', $url, [], [ 'people' => $people, 'shiporders' => $shiporders ]);

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