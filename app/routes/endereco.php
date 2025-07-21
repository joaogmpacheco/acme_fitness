<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\EnderecoController;

return function (App $app) {
    $app->group('/endereco', function (RouteCollectorProxy $group) {
        $group->get('', [EnderecoController::class, 'listar']);
        $group->get('/{id}', [EnderecoController::class, 'buscarPorId']);
        $group->post('', [EnderecoController::class, 'criar']);
        $group->put('/{id}', [EnderecoController::class, 'atualizar']);
        $group->delete('/{id}', [EnderecoController::class, 'deletar']);
    });
};
