<?php


namespace App\Tests\Controller;


use App\Tests\ApiBaseTestCase;

class TokenControllerTest extends ApiBaseTestCase
{
    public function testPOSTCreateToken()
    {
        $this->client->request('POST', self::BASE_API_URI.'/tokens', [], [], [
            'PHP_AUTH_USER' => 'Shinigami',
            'PHP_AUTH_PW' => 'Laser',
        ]);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        // Check that response has a 'token' property
        $this->assertTrue(property_exists(json_decode($response->getContent()), 'token'));
    }
}