<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\ItemVendaController;

return function (App $app) {
    $app->group('/itemVenda', function (RouteCollectorProxy $group) {
        $group->get('', [ItemVendaController::class, 'listar']);
        $group->get('/{id}', [ItemVendaController::class, 'buscarPorId']);
        $group->post('', [ItemVendaController::class, 'criar']);
        $group->put('/{id}', [ItemVendaController::class, 'atualizar']);
        $group->delete('/{id}', [ItemVendaController::class, 'deletar']);
    });
};
