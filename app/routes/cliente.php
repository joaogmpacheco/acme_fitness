<?php

use App\Controller\ClienteController;

$app->group('/cliente', function () {
    $this->get('', ClienteController::class . ':listar'); // GET /cliente
    $this->get('/{id}', ClienteController::class . ':listarPorId'); // GET /cliente/{id}
    $this->post('', ClienteController::class . ':criar'); // POST /cliente
    $this->put('/{id}', ClienteController::class . ':atualizar');  // PUT /cliente/{id}
    $this->delete('/{id}', ClienteController::class . ':deletar'); // DELETE /cliente/{id}
});