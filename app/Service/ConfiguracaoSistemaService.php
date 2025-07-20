<?php
namespace App\Service;

use App\DAO\ConfiguracaoSistemaDAO;
use App\Model\ConfiguracaoSistema;

class ConfiguracaoSistemaService {
    private ConfiguracaoSistemaDAO $dao;

    public function __construct(ConfiguracaoSistemaDAO $dao) {
        $this->dao = $dao;
    }

    public function listar(): array {
        return $this->dao->listar();
    }

    public function listarPorId(int $id): ?ConfiguracaoSistema {
        return $this->dao->listarPorId($id);
    }

    public function criar(array $data): bool {
        $configuracaoSistema = new ConfiguracaoSistema($data);
        return $this->dao->inserir($configuracaoSistema);
    }

    public function atualizar(int $id, array $data): bool {
        $configuracaoSistema = new ConfiguracaoSistema($data);
        $configuracaoSistema->setId($id);
        return $this->dao->atualizar($configuracaoSistema);
    }

    public function deletar(int $id): bool {
        return $this->dao->deletar($id);
    }
}

