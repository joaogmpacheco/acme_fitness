<?php

namespace App\Service;

use App\DAO\VendaDAO;
use App\Model\Venda;

class VendaService {
    private VendaDAO $dao;

    public function __construct() {
        $this->dao = new VendaDAO();
    }

    public function listar(): array {
        return $this->dao->listar();
    }

    public function listarPorId(int $id): ?Venda {
        return $this->dao->listarPorId($id);
    }

    public function criar(array $data): bool {
        $categoria = new Venda($data);
        return $this->dao->inserir($venda);
    }

    public function atualizar(int $id, array $data): bool {
        $venda = new Venda($data);
        $venda->setId($id); // garante que o ID esteja setado
        return $this->dao->atualizar($venda);
    }

    public function deletar(int $id): bool {
        return $this->dao->deletar($id);
    }
}
