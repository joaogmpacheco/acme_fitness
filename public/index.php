<?php

declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Dependencies (incluindo registro do PDO, DAOs, Services, Controllers)
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Repositories (se usar, ou remova se não precisar)
$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

// Build container
$container = $containerBuilder->build();

// Set container to AppFactory **antes** de criar o app
AppFactory::setContainer($container);
$app = AppFactory::create();

$callableResolver = $app->getCallableResolver();

// Register middleware
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

// Register routes
(require __DIR__ . '/../app/routes.php')($app);
(require __DIR__ . '/../app/routes/categoria.php')($app);
(require __DIR__ . '/../app/routes/cliente.php')($app);
(require __DIR__ . '/../app/routes/configuracaoSistema.php')($app);
(require __DIR__ . '/../app/routes/endereco.php')($app);
(require __DIR__ . '/../app/routes/itemVenda.php')($app);
(require __DIR__ . '/../app/routes/produto.php')($app);
(require __DIR__ . '/../app/routes/variacaoProduto.php')($app);
(require __DIR__ . '/../app/routes/venda.php')($app);

/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// Create ServerRequest from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create error handler & shutdown handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware (must be before BodyParsing & ErrorMiddleware)
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run app & emit response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
