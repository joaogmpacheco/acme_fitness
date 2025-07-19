<?php

namespace App\Service;

use App\DAO\ClienteDAO;
use App\Model\Cliente;

class ClienteService {
    private ClienteDAO $dao;

    public function __construct() {
        $this->dao = new ClienteDAO();
    }

    public function listar(): array {
        return $this->dao->listar();
    }

    public function listarPorId(int $id): ?Cliente {
        return $this->dao->listarPorId($id);
    }

    public function criar(array $data): bool {
        $cliente = new Cliente($data);
        return $this->dao->inserir($cliente);
    }

    public function atualizar(int $id, array $data): bool {
        $cliente = new Cliente($data);
        $cliente->setId($id); // garante que o ID esteja setado
        return $this->dao->atualizar($cliente);
    }

    public function deletar(int $id): bool {
        return $this->dao->deletar($id);
    }
}
