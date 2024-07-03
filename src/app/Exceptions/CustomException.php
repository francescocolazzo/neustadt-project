<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CustomException extends Exception
{
    public function __construct(string $message = '', protected array $data = [], protected int $customCode = Response::HTTP_BAD_REQUEST)
    {
        $this->code = intval($this->customCode);
        $this->message = $message;
    }

    public function getCustomCode(): string
    {
        return $this->customCode;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function convertCustomExceptionToResponse(Throwable $exception)
    {
        return response()->json([
            'status'  => Response::$statusTexts[$this->getCode()],
            'message' => $this->getData(),
            'code'    => $this->getCustomCode()
        ], $exception->getCode());
    }

}