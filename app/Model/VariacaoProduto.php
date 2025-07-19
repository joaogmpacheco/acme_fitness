<?php

namespace App\Model;
use JsonSerializable;

class VariacaoProduto implements JsonSerializable{
    private ?int $id;
    private int $produtoId;
    private string $tamanho;
    private int $estoque;

    /*Getters*/
    public function getId(){
        return $this->id;
    }
    public function getProdutoId(){
        return $this->produtoId;
    }
    public function getTamanho(){
        return $this->tamanho;
    }
    public function getEstoque(){
        return $this->estoque;
    }
    
    /*Setters*/
    public function setId(int $id){
        $this->id = $id;
    }
    public function setProdutoId(int $produtoId){
        if ($produtoId <= 0) {
            throw new \InvalidArgumentException("Categoria inválida");
        }
        $this->produtoId = $produtoId;
    }
    public function setTamanho(int $tamanho){
        $this->tamanho = $tamanho;
    }
    public function setEstoque(int $estoque){
        $this->estoque = $estoque;
    }

    public function __construct(array $data = []){
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->setProdutoId((int)($data['produtoId'] ?? 0));
            $this->setTamanho((int)($data['tamanho'] ?? 0));
            $this->setEstoque((int)($data['estoque'] ?? 0));
        }
    }

    public function toArray(): array {
        return [
            'id'    => $this->id,
            'produtoId'=> $this->produtoId,
            'tamanho'=> $this->tamanho,
            'estoque'=> $this->estoque,
        ];
    }
    public function jsonSerialize(){
        return $this->toArray();
    }

}