<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\ClienteController;

return function (App $app) {
    $app->group('/cliente', function (RouteCollectorProxy $group) {
        $group->get('', [ClienteController::class, 'listar']);
        $group->get('/{id}', [ClienteController::class, 'buscarPorId']);
        $group->post('', [ClienteController::class, 'criar']);
        $group->put('/{id}', [ClienteController::class, 'atualizar']);
        $group->delete('/{id}', [ClienteController::class, 'deletar']);
    });
};
