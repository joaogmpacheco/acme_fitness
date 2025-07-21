<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\VariacaoProdutoController;

return function (App $app) {
    $app->group('/variacaoProduto', function (RouteCollectorProxy $group) {
        $group->get('', [VariacaoProdutoController::class, 'listar']);
        $group->get('/{id}', [VariacaoProdutoController::class, 'buscarPorId']);
        $group->post('', [VariacaoProdutoController::class, 'criar']);
        $group->put('/{id}', [VariacaoProdutoController::class, 'atualizar']);
        $group->delete('/{id}', [VariacaoProdutoController::class, 'deletar']);
    });
};
