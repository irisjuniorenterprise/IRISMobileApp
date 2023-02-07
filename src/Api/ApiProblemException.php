<?php

namespace App\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiProblemException extends HttpException
{
    private ApiProblem $apiProblem;

    public function __construct(ApiProblem $apiProblem, $statusCode, string $message = '', \Throwable $previous = null, array $headers = [], int $code = 0)
    {
        $this->apiProblem = $apiProblem;
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    /**
     * @return ApiProblem
     */
    public function getApiProblem(): ApiProblem
    {
        return $this->apiProblem;
    }

}