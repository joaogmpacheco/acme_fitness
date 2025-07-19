<?php

use App\Controller\VariacaoProdutoController;

$app->group('/variacaoProduto', function () {
    $this->get('', VariacaoProdutoController::class . ':listar'); // GET /variacaoProduto
    $this->get('/{id}', VariacaoProdutoController::class . ':listarPorId'); // GET /variacaoProduto/{id}
    $this->post('', VariacaoProdutoController::class . ':criar'); // POST /variacaoProduto
    $this->put('/{id}', VariacaoProdutoController::class . ':atualizar');  // PUT /variacaoProduto/{id}
    $this->delete('/{id}', VariacaoProdutoController::class . ':deletar'); // DELETE /variacaoProduto/{id}
});