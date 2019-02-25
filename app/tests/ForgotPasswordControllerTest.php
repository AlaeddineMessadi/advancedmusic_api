<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class ForgotPasswordControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $mock = new MockHandler([new Response(200, [])]);
        $handler = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handler]);
	}

    public function testForgotPassword()
    {
        $response = $this->client->post('/api/forgotPassword', [
            'auth' => [
                'tony_admin',
                'adminpass'
            ],
            'json' => [
                'email' => 'myemail@example.com',
                'token' => 'my_token',
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
