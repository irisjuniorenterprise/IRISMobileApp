<?php

namespace App\Tests\Controller\Api;

use App\Test\ApiTestCase;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class EagleControllerTest extends ApiTestCase
{
    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function testPOSTNewEagle(): void
    {
        $fName = 'iris'.random_int(0,999);
        $data = array(
            'email' => 'test'.random_int(0,999).'@test.com',
            'password' => 'foo',
            'fname' => $fName,
            'lname' => 'test',
            'phone' => '12345111'
        );
        // to create an eagle
        $response = $this->client->post('/api/eagle', [
            'body' => json_encode($data, JSON_THROW_ON_ERROR)
        ]);


        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('/api/eagle/144',$response->getHeader('Location')[0]);
        $finishedData = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertArrayHasKey('email', $finishedData);
        $this->assertEquals('test', $data['lname']);
    }


    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function testGETOneEagle(): void
    {
        
        $response = $this->client->get('/api/eagle/2');
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertiesExist($response, array (
            'email',
            'fName',
            'lName',
            'phone'
        ));
        $this->asserter()->assertResponsePropertyEquals($response, 'phone', '29588144');

    }


    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function testGETEaglesCollection(): void
    {
        $response = $this->client->get('/api/eagle');
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertIsArray(json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR), 'eagles');
        //$this->asserter()->assertResponsePropertyCount($response, 'eagles', 8);
        //$this->asserter()->assertResponsePropertyEquals($response, 'eagles.email[0]', 'iris@test.com');


    }


    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function testPUTEagle(): void
    {

        $data = array(
            'email' => 'testIris@test.com',
            'password' => 'iris',
            'fname' => 'iris983',
            'lname' => 'iris',
            'phone' => '0'
        );
        $response = $this->client->put('/api/eagle/3', array (
            'body' => json_encode($data, JSON_THROW_ON_ERROR)
        ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyEquals($response, 'phone', '0');

    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function testDELETEEagle(): void
    {
        $response = $this->client->delete('/api/eagle/144');
        $this->assertEquals(204, $response->getStatusCode());
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function testPATCHEagle(): void
    {
        $data = array(
            'phone' => '01'
        );
        $response = $this->client->patch('/api/eagle/3', array (
            'body' => json_encode($data, JSON_THROW_ON_ERROR)
        ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyEquals($response, 'phone', '01');
        $this->asserter()->assertResponsePropertyEquals($response, 'email', 'testIris@test.com');

    }








    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function testValidationErrors(): void
    {
        $fName = 'iris'.random_int(0,999);
        $data = array(
            'password' => 'foo',
            'fname' => $fName,
            'lname' => 'test',
            'phone' => '12345111'
        );
        // to create an eagle
        $response = $this->client->post('/api/eagle', [
            'body' => json_encode($data, JSON_THROW_ON_ERROR)
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        $this->asserter()->assertResponsePropertiesExist($response, array(
            'type',
            'title',
            'errors',
        ));
        $this->asserter()->assertResponsePropertyExists($response, 'errors.email');
        $this->asserter()->assertResponsePropertyExists($response, 'errors.email');
        $this->asserter()->assertResponsePropertyEquals($response, 'errors.email[0]', 'Please enter your email');
        $this->asserter()->assertResponsePropertyDoesNotExist($response, 'errors.phone');
        $this->assertEquals('application/problem+json', $response->getHeader('Content-Type'));

    }


    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function testInvalidJson(): void
    {
        $invalidJson = <<<EOF
        {
            "email" : "test@test.com
            "password" : "iris",
            "fname" : "iris983",
            "lname" : "iris",
            "phone" : "009"
        }
EOF;
        // to create an eagle
        $response = $this->client->post('/api/eagle', [
            'body' => $invalidJson
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function testPOSTEagleEmpty(): void
    {
        $data = null;
        // to create an eagle
        $response = $this->client->post('/api/eagle', [
            'body' => json_encode($data, JSON_THROW_ON_ERROR)
        ]);


        $this->assertEquals(422, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyDoesNotExist($response, 'email');
    }


    /**
     * @throws GuzzleException
     */
    public function testRequiresAuthentication(): void
    {
        $response = $this->client->post('/api/eagle', [
            'body' => '[]'
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }


}
