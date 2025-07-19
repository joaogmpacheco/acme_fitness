<?php

use App\Controller\CategoriaController;

$app->group('/categoria', function () {
    $this->get('', CategoriaController::class . ':listar'); // GET /categoria
    $this->get('/{id}', CategoriaController::class . ':listarPorId'); // GET /categoria/{id}
    $this->post('', CategoriaController::class . ':criar'); // POST /categoria
    $this->put('/{id}', CategoriaController::class . ':atualizar');  // PUT /categoria/{id}
    $this->delete('/{id}', CategoriaController::class . ':deletar'); // DELETE /categoria/{id}
});