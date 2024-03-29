<?php

namespace App\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * A wrapper for holding data to be used for a application/problem+json response
 */
class ApiProblem
{


    public const TYPE_VALIDATION_ERROR = 'validation_error';
    public const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format';
    private static array $titles = array(
        self::TYPE_VALIDATION_ERROR => 'There was a validation error',
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format sent',
    );

    private int $statusCode;

    private $type;

    private $title;

    private $extraData = array();

    public function __construct($statusCode, $type = null)
    {
        $this->statusCode = $statusCode;

        if ($type === null)
        {
            $type = 'about:blank';
            $title = isset(Response::$statusTexts[$statusCode])
            ?? Response::$statusTexts[$statusCode];
        }else
        {
            if (!isset(self::$titles[$type])) {
                throw new \InvalidArgumentException('No title for type '.$type);
            }
            $title = self::$titles[$type];
        }
        $this->type = $type;
        $this->title = $title;
    }
    public function toArray(): array
    {
        return array_merge(
            $this->extraData,
            array(
                'status' => $this->statusCode,
                'type' => $this->type,
                'title' => $this->title,
            )
        );
    }
    public function set($name, $value): void
    {
        $this->extraData[$name] = $value;
    }
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}