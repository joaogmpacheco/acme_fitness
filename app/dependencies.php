<?php

declare(strict_types=1);

use function DI\autowire;

use App\Application\Settings\SettingsInterface;
use App\Controller\{
    CategoriaController,
    ClienteController,
    ConfiguracaoSistemaController,
    EnderecoController,
    ItemVendaController,
    ProdutoController,
    VariacaoProdutoController,
    VendaController
};

use App\Service\{
    CategoriaService,
    ClienteService,
    ConfiguracaoSistemaService,
    EnderecoService,
    ItemVendaService,
    ProdutoService,
    VariacaoProdutoService,
    VendaService
};

use App\DAO\{
    CategoriaDAO,
    ClienteDAO,
    ConfiguracaoSistemaDAO,
    EnderecoDAO,
    ItemVendaDAO,
    ProdutoDAO,
    VariacaoProdutoDAO,
    VendaDAO
};

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([

        // Logger
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler(
                $loggerSettings['path'],
                $loggerSettings['level']
            ));

            return $logger;
        },

        // PDO connection
        PDO::class => function () {
            return new PDO(
                'mysql:host=localhost;dbname=acme;charset=utf8mb4',
                'root',
                '', // senha
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        },

        // DAOs (autowire já injeta o PDO)
        CategoriaDAO::class => autowire(CategoriaDAO::class),
        ClienteDAO::class => autowire(ClienteDAO::class),
        ConfiguracaoSistemaDAO::class => autowire(ConfiguracaoSistemaDAO::class),
        EnderecoDAO::class => autowire(EnderecoDAO::class),
        ItemVendaDAO::class => autowire(ItemVendaDAO::class),
        ProdutoDAO::class => autowire(ProdutoDAO::class),
        VariacaoProdutoDAO::class => autowire(VariacaoProdutoDAO::class),
        VendaDAO::class => autowire(VendaDAO::class),

        // Services
        CategoriaService::class => autowire(CategoriaService::class),
        ClienteService::class => autowire(ClienteService::class),
        ConfiguracaoSistemaService::class => autowire(ConfiguracaoSistemaService::class),
        EnderecoService::class => autowire(EnderecoService::class),
        ItemVendaService::class => autowire(ItemVendaService::class),
        ProdutoService::class => autowire(ProdutoService::class),
        VariacaoProdutoService::class => autowire(VariacaoProdutoService::class),
        VendaService::class => autowire(VendaService::class),

        // Controllers
        CategoriaController::class => autowire(CategoriaController::class),
        ClienteController::class => autowire(ClienteController::class),
        ConfiguracaoSistemaController::class => autowire(ConfiguracaoSistemaController::class),
        EnderecoController::class => autowire(EnderecoController::class),
        ItemVendaController::class => autowire(ItemVendaController::class),
        ProdutoController::class => autowire(ProdutoController::class),
        VariacaoProdutoController::class => autowire(VariacaoProdutoController::class),
        VendaController::class => autowire(VendaController::class),
    ]);
};
