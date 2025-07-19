<?php

namespace App\Service;

use App\DAO\ProdutoDAO;
use App\Model\Produto;

class ProdutoService {
    private ProdutoDAO $dao;

    public function __construct() {
        $this->dao = new ProdutoDAO();
    }

    public function listar(): array {
        return $this->dao->listar();
    }

    public function listarPorId(int $id): ?Produto {
        return $this->dao->listarPorId($id);
    }

    public function criar(array $data): bool {
        $produto = new Produto($data);
        return $this->dao->inserir($produto);
    }

    public function atualizar(int $id, array $data): bool {
        $produto = new Produto($data);
        $produto->setId($id); // garante que o ID esteja setado
        return $this->dao->atualizar($produto);
    }

    public function deletar(int $id): bool {
        return $this->dao->deletar($id);
    }
}
