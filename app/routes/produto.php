<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\ProdutoController;

return function (App $app) {
    $app->group('/produto', function (RouteCollectorProxy $group) {
        $group->get('', [ProdutoController::class, 'listar']);
        $group->get('/{id}', [ProdutoController::class, 'buscarPorId']);
        $group->post('', [ProdutoController::class, 'criar']);
        $group->put('/{id}', [ProdutoController::class, 'atualizar']);
        $group->delete('/{id}', [ProdutoController::class, 'deletar']);
    });
};

