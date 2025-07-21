<?php

namespace App\DAO;
use App\Database\Connection;
use App\Model\Produto;
use PDO;

class ProdutoDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM produto");
        $produto = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $produto[] = new Produto($row);
        }

        return $produto;
    }

    public function listarPorId(int $id): ?Produto {
        $stmt = $this->pdo->prepare("SELECT * FROM produto WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Produto($row) : null;
    }

    public function inserir(Produto $produto): bool {
        $sql = "INSERT INTO produto (nome, imagem, precoBase, cor, data_cadastro, peso, descricao, categoria_id)
                VALUES (:nome, :imagem, :precoBase, :cor, :data_cadastro, :peso, :descricao, :categoria_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nome'         => $produto->getNome(),
            ':imagem'       => $produto->getImagem(),
            ':precoBase'    => $produto->getPrecoBase(),
            ':cor'          => $produto->getCor(),
            ':data_cadastro'=> $produto->getDataCadastro(),
            ':peso'         => $produto->getPeso(),
            ':descricao'    => $produto->getDescricao(),
            ':categoria_id' => $produto->getCategoriaId()
        ]);
    }

    public function atualizar(Produto $produto): bool {
        $sql = "UPDATE produto SET nome = :nome, imagem = :imagem, precoBase = :precoBase, cor = :cor,
                data_cadastro = :data_cadastro, peso = :peso, descricao = :descricao, categoria_id = :categoria_id
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nome'         => $produto->getNome(),
            ':imagem'       => $produto->getImagem(),
            ':precoBase'    => $produto->getPrecoBase(),
            ':cor'          => $produto->getCor(),
            ':data_cadastro'=> $produto->getDataCadastro(),
            ':peso'         => $produto->getPeso(),
            ':descricao'    => $produto->getDescricao(),
            ':categoria_id' => $produto->getCategoriaId(),
            ':id'           => $produto->getId()
        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM produto WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
