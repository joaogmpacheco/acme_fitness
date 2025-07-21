<?php

use Slim\App;
use App\Controller\CategoriaController;

return function (App $app) {
    $app->group('/categoria', function ($group) {
        $group->get('', [CategoriaController::class, 'listar']);
        $group->get('/{id}', [CategoriaController::class, 'buscarPorId']);
        $group->post('', [CategoriaController::class, 'inserir']);
        $group->put('/{id}', [CategoriaController::class, 'atualizar']);
        $group->delete('/{id}', [CategoriaController::class, 'deletar']);
    });
};
