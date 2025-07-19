<?php

namespace App\Service;

use App\DAO\ItemVendaDAO;
use App\Model\ItemVenda;

class ItemVendaService {
    private ItemVendaDAO $dao;

    public function __construct() {
        $this->dao = new ItemVendaDAO();
    }

    public function listar(): array {
        return $this->dao->listar();
    }

    public function listarPorId(int $id): ?ItemVenda {
        return $this->dao->listarPorId($id);
    }

    public function criar(array $data): bool {
        $itemVenda = new ItemVenda($data);
        return $this->dao->inserir($itemVenda);
    }

    public function atualizar(int $id, array $data): bool {
        $itemVenda = new ItemVenda($data);
        $itemVenda->setId($id); // garante que o ID esteja setado
        return $this->dao->atualizar($itemVenda);
    }

    public function deletar(int $id): bool {
        return $this->dao->deletar($id);
    }
}
