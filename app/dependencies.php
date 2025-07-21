<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

// DAO
use App\DAO\CategoriaDAO;
use App\DAO\ClienteDAO;
use App\DAO\ConfiguracaoSistemaDAO;
use App\DAO\EnderecoDAO;
use App\DAO\ItemVendaDAO;
use App\DAO\ProdutoDAO;
use App\DAO\VariacaoProdutoDAO;
use App\DAO\VendaDAO;

// Service
use App\Service\CategoriaService;
use App\Service\ClienteService;
use App\Service\ConfiguracaoSistemaService;
use App\Service\EnderecoService;
use App\Service\ItemVendaService;
use App\Service\ProdutoService;
use App\Service\VariacaoProdutoService;
use App\Service\VendaService;

return function (ContainerBuilder $containerBuilder): void {
    $containerBuilder->addDefinitions([

        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);
            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler($loggerSettings['path'], $loggerSettings['level']));
            return $logger;
        },

        // DAO bindings
        CategoriaDAO::class => fn(ContainerInterface $c) => new CategoriaDAO(),
        ClienteDAO::class => fn(ContainerInterface $c) => new ClienteDAO(),
        ConfiguracaoSistemaDAO::class => fn(ContainerInterface $c) => new ConfiguracaoSistemaDAO(),
        EnderecoDAO::class => fn(ContainerInterface $c) => new EnderecoDAO(),
        ItemVendaDAO::class => fn(ContainerInterface $c) => new ItemVendaDAO(),
        ProdutoDAO::class => fn(ContainerInterface $c) => new ProdutoDAO(),
        VariacaoProdutoDAO::class => fn(ContainerInterface $c) => new VariacaoProdutoDAO(),
        VendaDAO::class => fn(ContainerInterface $c) => new VendaDAO(),

        // Service bindings
        CategoriaService::class => fn(ContainerInterface $c) => new CategoriaService($c->get(CategoriaDAO::class)),
        ClienteService::class => fn(ContainerInterface $c) => new ClienteService($c->get(ClienteDAO::class)),
        ConfiguracaoSistemaService::class => fn(ContainerInterface $c) => new ConfiguracaoSistemaService($c->get(ConfiguracaoSistemaDAO::class)),
        EnderecoService::class => fn(ContainerInterface $c) => new EnderecoService($c->get(EnderecoDAO::class)),
        ItemVendaService::class => fn(ContainerInterface $c) => new ItemVendaService($c->get(ItemVendaDAO::class)),
        ProdutoService::class => fn(ContainerInterface $c) => new ProdutoService($c->get(ProdutoDAO::class)),
        VariacaoProdutoService::class => fn(ContainerInterface $c) => new VariacaoProdutoService($c->get(VariacaoProdutoDAO::class)),
        VendaService::class => fn(ContainerInterface $c) => new VendaService($c->get(VendaDAO::class)),
    ]);
};
