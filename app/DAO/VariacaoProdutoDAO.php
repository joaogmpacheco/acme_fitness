<?php

namespace App\DAO;
use App\Database\Connection;
use App\Model\VariacaoProduto;
use PDO;

class VariacaoProdutoDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM variacaoProduto");
        $variacaoProduto = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $variacaoProduto[] = new VariacaoProduto($row);
        }

        return $variacaoProduto;
    }

    public function ListarPorId(int $id): ?VariacaoProduto {
        $stmt = $this->pdo->prepare("SELECT * FROM variacaoProduto WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new VariacaoProduto($row) : null;
    }

    public function inserir(VariacaoProduto $variacaoProduto): bool {
        $sql = "INSERT INTO variacaoProduto (produtoId, tamanho, estoque)
                VALUES (:produtoId, :tamanho, :estoque)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':produtoId' => $variacaoProduto->getProdutoId(),
            ':tamanho' => $variacaoProduto->getTamanho(),
            ':estoque' => $variacaoProduto->getEstoque(),
        ]);
    }

    public function atualizar(VariacaoProduto $variacaoProduto): bool {
        $sql = "UPDATE variacaoProduto SET produtoId = :produtoId, tamanho = :tamanho, estoque = :estoque
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':produtoId' => $variacaoProduto->getProdutoId(),
            ':tamanho' => $variacaoProduto->getTamanho(),
            ':estoque' => $variacaoProduto->getEstoque(),

        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM variacaoProduto WHERE id = ?");
        return $stmt->execute([$id]);
    }
}