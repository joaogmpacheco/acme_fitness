<?php

declare(strict_types=1);

namespace App\Application\Handler;

use Psr\Log\LoggerInterface;
use Slim\Exception\HttpException;
use Slim\Interfaces\ErrorHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use JsonException;
use Throwable;

class HttpErrorHandler implements ErrorHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private ResponseFactoryInterface $responseFactory
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $statusCode = $this->getStatusCodeFromException($exception);
        $errorType = $this->getErrorTypeFromException($exception);

        if ($logErrors) {
            $this->logError($exception, $logErrorDetails);
        }

        $response = $this->responseFactory->createResponse($statusCode);
        $errorData = $this->buildErrorResponse($exception, $statusCode, $errorType, $displayErrorDetails);

        try {
            $response->getBody()->write(json_encode($errorData, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
        } catch (JsonException $e) {
            $response->getBody()->write('{"error":"Failed to encode error response"}');
            $statusCode = 500;
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Error-Type', $errorType)
            ->withStatus($statusCode);
    }

    private function getStatusCodeFromException(Throwable $exception): int
    {
        if ($exception instanceof HttpException) {
            return $exception->getCode(); // Ou $exception->getStatusCode() dependendo da versão do Slim
        }
        
        // Códigos de status padrão para diferentes tipos de exceção
        return match (true) {
            $exception instanceof \InvalidArgumentException => 400,
            $exception instanceof \DomainException => 422,
            default => 500
        };
    }

    private function getErrorTypeFromException(Throwable $exception): string
    {
        return match (true) {
            $exception instanceof HttpException => 'HTTP_ERROR',
            $exception instanceof \InvalidArgumentException => 'VALIDATION_ERROR',
            $exception instanceof \DomainException => 'DOMAIN_ERROR',
            default => 'SERVER_ERROR'
        };
    }

    private function logError(Throwable $exception, bool $includeTrace): void
    {
        $context = [
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
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
        $error = [
            'statusCode' => $statusCode,
            'error' => [
                'type' => $errorType,
                'description' => $displayDetails ? $exception->getMessage() : $this->getUserFriendlyMessage($errorType),
            ],
            'timestamp' => date('c')
        ];

        if ($displayDetails) {
            $error['details'] = [
                'exception' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            ];
        }

        return $error;
    }

    private function getUserFriendlyMessage(string $errorType): string
    {
        return match ($errorType) {
            'HTTP_ERROR' => 'Requisição inválida',
            'VALIDATION_ERROR' => 'Dados inválidos fornecidos',
            'DOMAIN_ERROR' => 'Violação de regra de negócio',
            default => 'Ocorreu um erro interno no servidor'
        };
    }
}