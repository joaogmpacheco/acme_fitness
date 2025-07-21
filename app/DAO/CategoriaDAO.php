<?php

namespace App\DAO;
use App\Database\Connection;
use App\Model\Categoria;
use PDO;

class CategoriaDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM categoria");
        $categoria = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoria[] = new Categoria($row);
        }

        return $categoria;
    }

    public function listarPorId(int $id): ?Categoria {
        $stmt = $this->pdo->prepare("SELECT * FROM categoria WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Categoria($row) : null;
    }

    public function inserir(Categoria $categoria): bool {
        $sql = "INSERT INTO categoria (nome, descricao)
                VALUES (:nome, :descricao)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nome' => $categoria->getNome(),
            ':descricao' => $categoria->getDescricao(),
        ]);
    }

    public function atualizar(Categoria $categoria): bool {
        $sql = "UPDATE categoria SET nome = :nome, descricao = :descricao
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nome' => $categoria->getNome(),
            ':descricao' => $categoria->getDescricao(),

        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM categoria WHERE id = ?");
        return $stmt->execute([$id]);
    }
}