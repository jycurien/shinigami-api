<?php


namespace App\Tests\Controller;


use App\Tests\ApiBaseTestCase;
use Symfony\Component\HttpFoundation\Response;

class CardOrderControllerTest extends ApiBaseTestCase
{
    public function testGETordersWithCenterAndCardNumbers()
    {
        $this->client->request('GET', self::BASE_API_URI.'/orders', [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'));
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $decodedResponse = json_decode($response->getContent());
        $this->assertIsArray($decodedResponse);
        $this->assertEquals(3, count($decodedResponse));
        $this->assertIsObject($decodedResponse[0]);
        $this->assertObjectHasAttribute('id', $decodedResponse[0]);
        $this->assertObjectHasAttribute('orderedAt', $decodedResponse[0]);
        $this->assertObjectHasAttribute('quantity', $decodedResponse[0]);
        $this->assertObjectHasAttribute('received', $decodedResponse[0]);
        $this->assertObjectHasAttribute('minCardCode', $decodedResponse[0]);
        $this->assertObjectHasAttribute('maxCardCode', $decodedResponse[0]);
        $this->assertEquals(100, $decodedResponse[0]->quantity);
        $this->assertEquals(false, $decodedResponse[0]->received);
    }
}