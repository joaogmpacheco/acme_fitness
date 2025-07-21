<?php

namespace App\DAO;
use App\Database\Connection;
use App\Model\ConfiguracaoSistema;
use PDO;

class ConfiguracaoSistemaDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM configuracaoSistema");
        $configuracaoSistema = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $configuracaoSistema[] = new ConfiguracaoSistema($row);
        }

        return $configuracaoSistema;
    }

    public function listarPorId(int $id): ?ConfiguracaoSistema {
        $stmt = $this->pdo->prepare("SELECT * FROM configuracaoSistema WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new ConfiguracaoSistema($row) : null;
    }

    public function inserir(ConfiguracaoSistema $configuracaoSistema): bool {
        $sql = "INSERT INTO configuracaoSistema (valorFretePadrao)
                VALUES (:valorFretePadrao)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':valorFretePadrao' => $configuracaoSistema->getValorFretePadrao(),
        ]);
    }

    public function atualizar(ConfiguracaoSistema $configuracaoSistema): bool {
        $sql = "UPDATE configuracaoSistema SET valorFretePadrao = :valorFretePadrao
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':valorFretePadrao' => $configuracaoSistema->getValorFretePadrao(),
        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM configuracaoSistema WHERE id = ?");
        return $stmt->execute([$id]);
    }
}