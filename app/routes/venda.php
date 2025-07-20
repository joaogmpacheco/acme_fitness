<?php

use App\Controller\VendaController;

$app->group('/venda', function () {
    $this->get('', VendaController::class . ':listar');         // GET /venda
    $this->get('/{id}', VendaController::class . ':buscarPorId'); // GET /venda/{id}
    $this->post('', VendaController::class . ':criar');          // POST /venda
    $this->put('/{id}', VendaController::class . ':atualizar');  // PUT /venda/{id}
    $this->delete('/{id}', VendaController::class . ':deletar'); // DELETE /venda/{id}
});

?>