<?php

use App\Controller\ItemVendaController;

$app->group('/itemVenda', function () {
    $this->get('', ItemVendaController::class . ':listar'); // GET /itemVenda
    $this->get('/{id}', ItemVendaController::class . ':listarPorId'); // GET /itemVenda/{id}
    $this->post('', ItemVendaController::class . ':criar'); // POST /itemVenda
    $this->put('/{id}', ItemVendaController::class . ':atualizar');  // PUT /itemVenda/{id}
    $this->delete('/{id}', ItemVendaController::class . ':deletar'); // DELETE /itemVenda/{id}
});