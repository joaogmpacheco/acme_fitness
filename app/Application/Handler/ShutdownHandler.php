<?php

declare(strict_types=1);

namespace App\Application\Handler;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpException;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;

class ShutdownHandler
{
    private ServerRequestInterface $request;
    private ErrorHandlerInterface $errorHandler;
    private bool $displayErrorDetails;

    public function __construct(
        ServerRequestInterface $request,
        ErrorHandlerInterface $errorHandler,
        bool $displayErrorDetails
    ) {
        $this->request = $request;
        $this->errorHandler = $errorHandler;
        $this->displayErrorDetails = $displayErrorDetails;
    }

    public function __invoke(): void
    {
        $error = error_get_last();

        if ($error && $this->isFatalError($error['type'])) {
            $exception = $this->createExceptionFromError($error);
            $this->errorHandler->__invoke(
                $this->request,
                $exception,
                $this->displayErrorDetails,
                true,
                $this->displayErrorDetails
            );
        }
    }

    private function isFatalError(int $type): bool
    {
        return in_array($type, [
            E_ERROR,
            E_CORE_ERROR,
            E_COMPILE_ERROR,
            E_PARSE,
            E_RECOVERABLE_ERROR,
            E_USER_ERROR
        ], true);
    }

    private function createExceptionFromError(array $error): Throwable
    {
        $message = $error['message'];
        $code = $error['type'];
        $file = $error['file'];
        $line = $error['line'];

        // Customize exception based on error type if needed
        if (str_contains($message, 'Allowed memory size')) {
            return new HttpException(
                $this->request,
                'Excedido o limite de memória do servidor',
                500
            );
        }

        return new \ErrorException($message, $code, 1, $file, $line);
    }
}