<?php

declare(strict_types=1);

namespace App\Application\Handler;

use Psr\Log\LoggerInterface;
use Slim\Exception\HttpException;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Response;
use Throwable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use JsonException;

class HttpErrorHandler implements ErrorHandlerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $statusCode = $this->getHttpStatusCode($exception);
        $errorType = $this->getErrorType($exception);

        if ($logErrors) {
            $this->logError($exception, $logErrorDetails);
        }

        $response = new Response();
        $error = $this->buildErrorResponse($exception, $statusCode, $errorType, $displayErrorDetails);

        try {
            $response->getBody()->write(json_encode($error, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
        } catch (JsonException $e) {
            $response->getBody()->write('{"error":"Failed to encode error response"}');
            $statusCode = 500;
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Error-Type', $errorType)
            ->withStatus($statusCode);
    }

    private function getHttpStatusCode(Throwable $exception): int
    {
        return $exception instanceof HttpException ? $exception->getStatusCode() : 500;
    }

    private function getErrorType(Throwable $exception): string
    {
        return $exception instanceof HttpException ? 'HTTP_ERROR' : 'SERVER_ERROR';
    }

    private function logError(Throwable $exception, bool $includeTrace): void
    {
        $context = [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];

        if ($includeTrace) {
            $context['trace'] = $exception->getTrace();
        }

        $this->logger->error($exception->getMessage(), $context);
    }

    private function buildErrorResponse(
        Throwable $exception,
        int $statusCode,
        string $errorType,
        bool $displayDetails
    ): array {
        $response = [
            'statusCode' => $statusCode,
            'error' => [
                'type' => $errorType,
                'description' => $displayDetails ? $exception->getMessage() : $this->getFriendlyMessage($errorType),
            ],
            'timestamp' => date('c')
        ];

        if ($displayDetails) {
            $response['details'] = [
                'exception' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            ];
        }

        return $response;
    }

    private function getFriendlyMessage(string $errorType): string
    {
        return match ($errorType) {
            'HTTP_ERROR' => 'Requisição inválida',
            default => 'Ocorreu um erro interno no servidor'
        };
    }
}