<?php


namespace App\Models;


class Response
{
    private $isSuccess;
    private $httpCode;
    private $response;

    public static function Success(array $successResponse, int $httpStatus = 200): Response
    {
        return new Response(true, $httpStatus, $successResponse);
    }

    public static function Error(array $errorResponse, int $httpStatus): Response
    {
        return new Response(false, $httpStatus, $errorResponse);
    }

    private function __construct(bool $isSuccess, int $httpCode, array $response)
    {
        $this->isSuccess = $isSuccess;
        $this->httpCode = $httpCode;
        $this->response = $response;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }
}
