<?php

namespace App\DAO;
use App\Database\Connection;
use App\Model\Venda;
use PDO;

class VendaDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::get();
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM venda");
        $venda = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $venda[] = new Venda($row);
        }

        return $venda;
    }

    public function listarPorId(int $id): ?Venda {
        $stmt = $this->pdo->prepare("SELECT * FROM venda WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Venda($row) : null;
    }

    public function inserir(Venda $venda): bool {
        $sql = "INSERT INTO venda (clienteId, enderecoId, valorFrete, valorTotal, formaPagamento, desconto, data_venda)
                VALUES (:clienteId, :enderecoId, :valorFrete, :valorTotal, :formaPagamento, :desconto, :data_venda)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':clienteId'         => $venda->getClienteId(),
            ':enderecoId'       => $venda->getEnderecoId(),
            ':valorFrete'    => $venda->getValorFrete(),
            ':valorTotal'          => $venda->getValorTotal(),
            ':formaPagamento'=> $venda->getFormaPagamento(),
            ':desconto'         => $venda->getDesconto(),
            ':dataVenda' => $venda->getDataVenda(),
        ]);
    }

    public function atualizar(Venda $venda): bool {
        $sql = "UPDATE venda SET clienteId = :clienteId, enderecoId = :enderecoId, valorFrete = :valorFrete, valorTotal = :valorTotal, formaPagamento = :formaPagamento, desconto = :desconto, dataVenda = :dataVenda
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':cliente' => $venda->getClienteId(),
            ':endereco'=> $venda->getEnderecoId(),
            'valorTotal'=> $venda->getValorTotal(),
            ':valorFrete'=> $venda->getValorFrete(),
            ':desconto'=> $venda->getDesconto(),
            'dataVenda'=> $venda->getDataVenda(),

        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM venda WHERE id = ?");
        return $stmt->execute([$id]);
    }
}