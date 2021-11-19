<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiBaseTestCase extends WebTestCase
{
    const BASE_API_URI = 'https://127.0.0.1:2222';

    protected $client;
    protected $JWTEncoder;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        self::bootKernel();
        $container = static::getContainer();
        $this->JWTEncoder = $container->get('lexik_jwt_authentication.encoder');
    }

    protected function getAuthorizedHeaders($username, $password, $headers = array())
    {
        $token = $this->JWTEncoder->encode([
            'username' => $username,
            'password' => $password,
            'exp' => time() + 3600
        ]);
        $headers['HTTP_AUTHORIZATION'] = 'Bearer '.$token;
        return $headers;
    }
}