<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\ConfiguracaoSistemaController;

return function (App $app) {
    $app->group('/configuracaoSistema', function (RouteCollectorProxy $group) {
        $group->get('', [ConfiguracaoSistemaController::class, 'listar']);
        $group->get('/{id}', [ConfiguracaoSistemaController::class, 'buscarPorId']);
        $group->post('', [ConfiguracaoSistemaController::class, 'criar']);
        $group->put('/{id}', [ConfiguracaoSistemaController::class, 'atualizar']);
        $group->delete('/{id}', [ConfiguracaoSistemaController::class, 'deletar']);
    });
};
