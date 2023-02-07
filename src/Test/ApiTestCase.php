<?php
namespace App\Test;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
class ApiTestCase extends TestCase
{

    private static Client $staticClient;
    private $responseAsserter;

    protected Client $client;
    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass(): void
    {
        self::$staticClient = new Client([
            'base_uri' => 'http://localhost:8000',
            'defaults' => [
                'exceptions' => false,
            ]
        ]);
    }

    public function setUp() :void
    {
        $this->client = self::$staticClient;
    }

    protected function asserter(): ResponseAsserter
    {
        if ($this->responseAsserter === null)
        {
            $this->responseAsserter = new ResponseAsserter();
        }
        return $this->responseAsserter;
    }



}