<?php

namespace App\DAO;
use App\Database\Connection;
use App\Model\ItemVenda;
use PDO;

class ItemVendaDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM itemVenda");
        $itemVenda = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $itemVenda[] = new ItemVenda($row);
        }

        return $itemVenda;
    }

    public function listarPorId(int $id): ?ItemVenda {
        $stmt = $this->pdo->prepare("SELECT * FROM itemVenda WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new ItemVenda($row) : null;
    }

    public function inserir(ItemVenda $itemVenda): bool {
        $sql = "INSERT INTO itemVenda (nome, descricao)
                VALUES (:nome, :descricao)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'vendaId' => $itemVenda->getVendaId(),
            ':variacaoId' => $itemVenda->getVariacaoId(),
            ':precoVenda' => $itemVenda->getPrecoVenda(),
        ]);
    }

    public function atualizar(ItemVenda $itemVenda): bool {
        $sql = "UPDATE itemVenda SET nome = :nome, descricao = :descricao
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'vendaId' => $itemVenda->getVendaId(),
            ':variacaoId' => $itemVenda->getVariacaoId(),
            ':precoVenda' => $itemVenda->getPrecoVenda(),

        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM itemVenda WHERE id = ?");
        return $stmt->execute([$id]);
    }
}