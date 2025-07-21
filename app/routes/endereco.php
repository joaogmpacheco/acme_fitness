<?php

use App\Controller\EnderecoController;

$app->group('/endereco', function () {
    $this->get('', EnderecoController::class . ':listar');         // GET /endereco
    $this->get('/{id}', EnderecoController::class . ':listarPorId'); // GET /endereco/{id}
    $this->post('', EnderecoController::class . ':criar');          // POST /endereco
    $this->put('/{id}', EnderecoController::class . ':atualizar');  // PUT /endereco/{id}
    $this->delete('/{id}', EnderecoController::class . ':deletar'); // DELETE /endereco/{id}
});