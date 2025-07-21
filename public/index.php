<?php

declare(strict_types=1);

use App\Application\Handler\HttpErrorHandler;
use App\Application\Handler\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

// Carregamento inicial
require __DIR__ . '/../vendor/autoload.php';

// Configuração inicial de tratamento de erros
set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

try {
    // Construção do container DI
    $containerBuilder = new ContainerBuilder();
    // Carregar configurações
    $settings = require __DIR__ . '/../app/settings.php';
    $settings($containerBuilder);

    // Carregar dependências
    (require __DIR__ . '/../app/dependencies.php')($containerBuilder);
    (require __DIR__ . '/../app/repositories.php')($containerBuilder);

    // Construir container
    $container = $containerBuilder->build();

    // Configurar aplicação Slim
    AppFactory::setContainer($container);
    $app = AppFactory::create();
    $app->setBasePath((function () {
        return $_SERVER['SCRIPT_NAME'] ?? '';
    })());

    // Registrar middlewares
    (require __DIR__ . '/../app/middleware.php')($app);

    // Registrar rotas
    $routeFiles = [
        'routes.php',
        'routes/categoria.php',
        'routes/cliente.php',
        'routes/configuracaoSistema.php',
        'routes/endereco.php',
        'routes/itemVenda.php',
        'routes/produto.php',
        'routes/variacaoProduto.php',
        'routes/venda.php',
        'Application/Handler/HttpErrorHandler.php'
    ];

    foreach ($routeFiles as $routeFile) {
        if (file_exists(__DIR__ . '/../app/' . $routeFile)) {
            (require __DIR__ . '/../app/' . $routeFile)($app);
        }
    }

    // Configurações de erro
    $settings = $container->get(SettingsInterface::class);
    $displayErrorDetails = $settings->get('displayErrorDetails');
    $logError = $settings->get('logError');
    $logErrorDetails = $settings->get('logErrorDetails');

    // Criar request
    $request = ServerRequestCreatorFactory::create()
                ->createServerRequestFromGlobals();

    // Configurar handlers de erro
    $responseFactory = $app->getResponseFactory();
    $logger = $container->get(LoggerInterface::class);
    $errorHandler = new HttpErrorHandler($logger, $responseFactory);

    $shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
    register_shutdown_function($shutdownHandler);

    // Adicionar middlewares
    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();

    $errorMiddleware = $app->addErrorMiddleware(
        $displayErrorDetails,
        $logError,
        $logErrorDetails,
        $logger
    );
    $errorMiddleware->setDefaultErrorHandler($errorHandler);

    // Executar aplicação
    $response = $app->handle($request);
    $responseEmitter = new ResponseEmitter();
    $responseEmitter->emit($response);

} catch (Throwable $e) {
    // Tratamento de erros globais
    if (isset($logger)) {
        $logger->error($e->getMessage(), ['exception' => $e]);
    }
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => 'Ocorreu um erro interno no servidor',
        'details' => $displayErrorDetails ? $e->getMessage() : null
    ]);
    exit(1);
}