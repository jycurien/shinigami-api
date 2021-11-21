<?php

// php -dxdebug.mode=coverage bin/phpunit --coverage-html ./var/tests
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

    public function testGETFindCardByCode()
    {
        $correctCardNumber = 1241000008;
        $this->client->request('GET', self::BASE_API_URI.'/cards/code-'.$correctCardNumber, [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'));
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsValidJsonCardResponse(Response::HTTP_OK, $response);

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

    public function testPOSTCreateCard()
    {
        $correctCenterCode = 124;
        $body = json_encode(["center" => $correctCenterCode]);
        $this->client->request('POST', self::BASE_API_URI.'/cards', [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'), $body);
        $response = $this->client->getResponse();
        $decodedCard = $this->assertIsValidJsonCardResponse(Response::HTTP_OK, $response);
        $this->assertEquals('numeric', $decodedCard->type);
        $this->assertEquals('124', $decodedCard->centerCode);
        $this->assertEquals(null, $decodedCard->activatedAt);

        // TODO test no center code
        $this->client->request('POST', self::BASE_API_URI.'/cards', [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'));
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        // TODO test wrong center code
    }

    public function testPUTUpdateActivationDate()
    {
        $correctCardNumber = 1241000008;
        $this->client->request('PUT', self::BASE_API_URI.'/cards/'.$correctCardNumber, [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'));
        $response = $this->client->getResponse();
        $decodedCard = $this->assertIsValidJsonCardResponse(Response::HTTP_CREATED, $response);
        $this->assertEquals((new \DateTime())->format('YY-mm-dd'), (new \DateTime($decodedCard->activatedAt))->format('YY-mm-dd'));

        $alreadyActivatedCardNumber = 1261001002;
        $this->client->request('PUT', self::BASE_API_URI.'/cards/'.$alreadyActivatedCardNumber, [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'));
        $response = $this->client->getResponse();
        $this->assertEquals(null, json_decode($response->getContent()));

        $wrongCardNumber = 1241000007;
        $this->client->request('PUT', self::BASE_API_URI.'/cards/'.$wrongCardNumber, [], [], $this->getAuthorizedHeaders('Shinigami', 'Laser'));
        $response = $this->client->getResponse();
        $this->assertEquals(null, json_decode($response->getContent()));
    }

    private function assertIsValidJsonCardResponse(int $expectedHTTPCode, $response): \stdClass
    {
        $this->assertEquals($expectedHTTPCode, $response->getStatusCode());
        $decodedCard = json_decode($response->getContent());
        $this->assertObjectHasAttribute("id", $decodedCard);
        $this->assertObjectHasAttribute("type", $decodedCard);
        $this->assertObjectHasAttribute("centerCode", $decodedCard);
        $this->assertObjectHasAttribute("cardCode", $decodedCard);
        $this->assertObjectHasAttribute("activatedAt", $decodedCard);
        $this->assertObjectHasAttribute("checkSum", $decodedCard);

        return $decodedCard;
    }
}