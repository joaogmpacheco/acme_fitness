<?php

namespace App\DAO;
use App\Database\Connection;
use App\Model\Endereco;
use PDO;

class EnderecoDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM endereco");
        $endereco = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $endereco[] = new Endereco($row);
        }

        return $endereco;
    }

    public function searchById(int $id): ?Endereco {
        $stmt = $this->pdo->prepare("SELECT * FROM endereco WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Endereco($row) : null;
    }

    public function inserir(Endereco $endereco): bool {
        $sql = "INSERT INTO endereco (logradouro, cidade, bairro, :numero, :cep, :complemento, :clienteId)
                VALUES (:logradouro, :cidade, :bairro, :numero, :cep, :complemento, :clienteId)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':logradouro' => $endereco->getLogradouro(),
            ':cidade' => $endereco->getCidade(),
            ':bairro' => $endereco->getBairro(),
            ':numero' => $endereco->getNumero(),
            ':cep' => $endereco->getCep(),
            ':complemento' => $endereco->getComplemento(),
            ':clienteId' => $endereco->getClienteId(),
        ]);
    }

    public function atualizar(Endereco $endereco): bool {
        $sql = "UPDATE endereco SET logradouro = :logradouro, cidade = :cidade, bairro = :bairro, numero = :numero, cep = :cep, complemento = :complemento, clienteId = clienteId
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':logradouro' => $endereco->getLogradouro(),
            ':cidade' => $endereco->getCidade(),
            ':bairro' => $endereco->getBairro(),
            ':numero' => $endereco->getNumero(),
            ':cep' => $endereco->getCep(),
            ':complemento' => $endereco->getComplemento(),
            ':clienteId' => $endereco->getClienteId(),

        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM endereco WHERE id = ?");
        return $stmt->execute([$id]);
    }
}