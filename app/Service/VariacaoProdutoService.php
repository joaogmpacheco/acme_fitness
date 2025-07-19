<?php

namespace App\Service;

use App\DAO\VariacaoProdutoDAO;
use App\Model\VariacaoProduto;

class VariacaoProdutoService {
    private VariacaoProdutoDAO $dao;

    public function __construct() {
        $this->dao = new VariacaoProdutoDAO();
    }

    public function listar(): array {
        return $this->dao->listar();
    }

    public function listarPorId(int $id): ?VariacaoProduto {
        return $this->dao->listarPorId($id);
    }

    public function criar(array $data): bool {
        $variacaoProduto = new VariacaoProduto($data);
        return $this->dao->inserir($variacaoProduto);
    }

    public function atualizar(int $id, array $data): bool {
        $variacaoProduto = new VariacaoProduto($data);
        $variacaoProduto->setId($id); // garante que o ID esteja setado
        return $this->dao->atualizar($variacaoProduto);
    }

    public function deletar(int $id): bool {
        return $this->dao->deletar($id);
    }
}
