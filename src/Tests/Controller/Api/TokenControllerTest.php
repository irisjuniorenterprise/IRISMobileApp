<?php

namespace App\Tests\Controller\Api;

use App\Test\ApiTestCase;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class TokenControllerTest extends ApiTestCase
{
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function  testPOSTCreateToken(): void
    {
        $response = $this->client->post('/api/tokens', [
            'email' => 'iris@test.com',
            'password' => 'iris'
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyExists(
            $response,
            'token'
        );
    }
}