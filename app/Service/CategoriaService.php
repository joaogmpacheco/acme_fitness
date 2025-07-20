<?php
namespace App\Service;

use App\DAO\CategoriaDAO;
use App\Model\Categoria;

class CategoriaService {
    private CategoriaDAO $dao;

    public function __construct(CategoriaDAO $dao) {
        $this->dao = $dao;
    }

    public function listar(): array {
        return $this->dao->listar();
    }

    public function listarPorId(int $id): ?Categoria {
        return $this->dao->listarPorId($id);
    }

    public function criar(array $data): bool {
        $categoria = new Categoria($data);
        return $this->dao->inserir($categoria);
    }

    public function atualizar(int $id, array $data): bool {
        $categoria = new Categoria($data);
        $categoria->setId($id);
        return $this->dao->atualizar($categoria);
    }

    public function deletar(int $id): bool {
        return $this->dao->deletar($id);
    }
}

