<?php


namespace App\Tests\Controller;


use App\Tests\ApiBaseTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CardControllerTest extends ApiBaseTestCase
{
    public function testRequiresAuthentication()
    {
        $this->client->catchExceptions(false);
        $this->expectExceptionCode(Response::HTTP_FORBIDDEN);
        $this->client->request('GET', self::BASE_API_URI.'/cards');

    }
}