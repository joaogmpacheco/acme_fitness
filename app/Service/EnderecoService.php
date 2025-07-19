<?php

namespace App\Service;

use App\DAO\EnderecoDAO;
use App\Model\Endereco;

class EnderecoService {
    private EnderecoDAO $dao;

    public function __construct() {
        $this->dao = new EnderecoDAO();
    }

    public function listar(): array {
        return $this->dao->listar();
    }

    public function listarPorId(int $id): ?Endereco {
        return $this->dao->listarPorId($id);
    }

    public function criar(array $data): bool {
        $endereco = new Endereco($data);
        return $this->dao->inserir($endereco);
    }

    public function atualizar(int $id, array $data): bool {
        $endereco = new Endereco($data);
        $endereco->setId($id); // garante que o ID esteja setado
        return $this->dao->atualizar($endereco);
    }

    public function deletar(int $id): bool {
        return $this->dao->deletar($id);
    }
}
