<?php

namespace App\DAO;
use App\Database\Connection;
use App\Model\Cliente;
use PDO;

class ClienteDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM cliente");
        $cliente = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cliente[] = new Cliente($row);
        }

        return $cliente;
    }

    public function ListarPorId(int $id): ?Cliente {
        $stmt = $this->pdo->prepare("SELECT * FROM cliente WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Cliente($row) : null;
    }

    public function inserir(Cliente $cliente): bool {
        $sql = "INSERT INTO cliente (nomeCompleto, cpf descricao)
                VALUES (:nomeCompleto, :cpf, :descricao)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nomeCompleto' => $cliente->getNomeCompleto(),
            ':cpf' => $cliente->getCpf(),
            ':dataNascimento' => $cliente->getDataNascimento(),
        ]);
    }

    public function atualizar(Cliente $cliente): bool {
        $sql = "UPDATE cliente SET nomeCompleto = :nomeCompleto, cpf = :cpf, descricao = :descricao
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nomeCompleto' => $cliente->getNomeCompleto(),
            ':cpf' => $cliente->getCpf(),
            ':dataNascimento' => $cliente->getDataNascimento(),

        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM cliente WHERE id = ?");
        return $stmt->execute([$id]);
    }
}