<?php

use App\Controller\ConfiguracaoSistemaController;

$app->group('/configuracaoSistema', function () {
    $this->get('', ConfiguracaoSistemaController::class . ':listar'); // GET /configuracaoSistema
    $this->get('/{id}', ConfiguracaoSistemaController::class . ':listarPorId'); // GET /configuracaoSistema/{id}
    $this->post('', ConfiguracaoSistemaController::class . ':criar'); // POST /configuracaoSistema
    $this->put('/{id}', ConfiguracaoSistemaController::class . ':atualizar');  // PUT /configuracaoSistema/{id}
    $this->delete('/{id}', ConfiguracaoSistemaController::class . ':deletar'); // DELETE /configuracaoSistema/{id}
});