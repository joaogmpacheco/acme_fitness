<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\VendaController;

return function (App $app) {
    $app->group('/venda', function (RouteCollectorProxy $group) {
        $group->get('', [VendaController::class, 'listar']);
        $group->get('/{id}', [VendaController::class, 'buscarPorId']);
        $group->post('', [VendaController::class, 'criar']);
        $group->put('/{id}', [VendaController::class, 'atualizar']);
        $group->delete('/{id}', [VendaController::class, 'deletar']);
    });
};
