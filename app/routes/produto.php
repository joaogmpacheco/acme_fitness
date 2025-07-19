<?php 

use App\Controller\ProdutoController;

$app->group('/produto', function () {
    $this->get('', ProdutoController::class . ':listar');         // GET /produto
    $this->get('/{id}', ProdutoController::class . ':listarPorId'); // GET /produto/{id}
    $this->post('', ProdutoController::class . ':criar');          // POST /produto
    $this->put('/{id}', ProdutoController::class . ':atualizar');  // PUT /produto/{id}
    $this->delete('/{id}', ProdutoController::class . ':deletar'); // DELETE /produto/{id}
});


?>