<?php


namespace App\Tests\Controller;


use App\Tests\ApiBaseTestCase;
use Symfony\Component\HttpFoundation\Response;

class CardControllerTest extends ApiBaseTestCase
{
    public function testRequiresAuthentication()
    {
        $this->client->catchExceptions(false);
        $this->expectExceptionCode(Response::HTTP_FORBIDDEN);
        $this->client->request('GET', self::BASE_API_URI.'/cards');
    }

    public function testGETfindCardByCode()
    {
        $correctCardNumber = 1241000008;
        $this->client->request('GET', self::BASE_API_URI.'/cards/code-'.$correctCardNumber, [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'));
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertObjectHasAttribute("type", json_decode($response->getContent()));
        $this->assertObjectHasAttribute("centerCode", json_decode($response->getContent()));
        $this->assertObjectHasAttribute("cardCode", json_decode($response->getContent()));
        $this->assertObjectHasAttribute("activatedAt", json_decode($response->getContent()));
        $this->assertObjectHasAttribute("checkSum", json_decode($response->getContent()));

        $wrongCardNumber = 1241000007;
        $this->client->request('GET', self::BASE_API_URI.'/cards/code-'.$wrongCardNumber, [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'));
        $response = $this->client->getResponse();
        $this->assertEquals('null', $response->getContent());
    }

    public function testGETFindLatestCreatedCards()
    {
        $this->client->request('GET', self::BASE_API_URI.'/cards', [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'));
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}