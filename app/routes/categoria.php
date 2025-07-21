<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\CategoriaController;

return function (App $app) {
    $app->group('/categoria', function (RouteCollectorProxy $group) {
        $group->get('', [CategoriaController::class, 'listar']);
        $group->get('/{id}', [CategoriaController::class, 'buscarPorId']);
        $group->post('', [CategoriaController::class, 'criar']);
        $group->put('/{id}', [CategoriaController::class, 'atualizar']);
        $group->delete('/{id}', [CategoriaController::class, 'deletar']);
    });
};
